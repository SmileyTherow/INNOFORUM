<?php

namespace App\Http\Controllers\Pesan;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;

class ConversationController extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $conversations = $user->conversations()
            ->with(['users' => function ($q) use ($user) {
                $q->select('users.id', 'name', 'email');
            }, 'messages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->orderByDesc('last_message_at')
            ->get();

        $conversationsForJs = $conversations->map(function ($c) use ($user) {
            $other = $c->users->firstWhere('id', '<>', $user->id) ?? $c->users->first();

            $lastMessageTime = '';
            if ($c->last_message_at) {
                try {
                    $dt = $c->last_message_at instanceof Carbon ? $c->last_message_at : Carbon::parse($c->last_message_at);
                    $lastMessageTime = $dt->diffForHumans();
                } catch (\Throwable $e) {
                    $lastMessageTime = (string) $c->last_message_at;
                }
            }

            return [
                'id' => $c->id,
                'other' => [
                    'id' => $other?->id,
                    'name' => $other?->name ?? 'User',
                ],
                'last_message_preview' => optional($c->messages->first())->body,
                'last_message_time' => $lastMessageTime,
            ];
        })->values();

        return view('pesan.index', compact('conversations', 'conversationsForJs'));
    }

    public function store(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);

        $me = $request->user();
        $targetId = (int)$request->input('user_id');

        if ($me->id === $targetId) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'Cannot create conversation with yourself'], 400);
            }
            return redirect()->back()->with('error', 'Tidak bisa mengirim pesan ke diri sendiri.');
        }

        $conversation = Conversation::findOrCreateOneOnOne($me->id, $targetId);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['conversation' => $conversation], 200);
        }

        return redirect()->route('pesan.index', ['conv' => $conversation->id]);
    }

    public function messages(Request $request, Conversation $conversation)
    {
        $user = $request->user();

        if (!$conversation->users()->where('users.id', $user->id)->exists()) {
            abort(403);
        }

        $limit = (int) $request->query('limit', 50);

        $messages = $conversation->messages()
            ->with('sender')
            ->latest()
            ->limit($limit)
            ->get()
            ->reverse()
            ->values();

        $payload = $messages->map(function ($m) {
            return [
                'id' => $m->id,
                'conversation_id' => $m->conversation_id,
                'sender' => [
                    'id' => $m->sender->id,
                    'name' => $m->sender->name,
                    'avatar' => $m->sender->avatar ? asset('storage/'.$m->sender->avatar) : null,
                ],
                'body' => $m->body,
                'attachment' => $m->attachment ? asset('storage/'.$m->attachment) : null,
                'attachment_type' => $m->attachment_type,
                'created_at' => $m->created_at?->toDateTimeString(),
            ];
        });

        return response()->json($payload);
    }
}