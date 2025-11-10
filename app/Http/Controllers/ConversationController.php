<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // load user's conversations with last message timestamp and participant info
        $conversations = $user->conversations()
            ->with(['users' => function ($q) use ($user) {
                $q->select('users.id', 'name', 'email'); // adjust columns
            }, 'messages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->orderByDesc('last_message_at')
            ->get();

        return view('pesan.index', compact('conversations'));
    }

    // Create or return existing 1-on-1 conversation between auth user and target user
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $me = $request->user();
        $targetId = (int)$request->input('user_id');

        if ($me->id === $targetId) {
            return response()->json(['message' => 'Cannot create conversation with yourself'], 400);
        }

        $conversation = Conversation::findOrCreateOneOnOne($me->id, $targetId);

        return response()->json(['conversation' => $conversation], 200);
    }

    // API to fetch messages (paginated)
    public function messages(Request $request, Conversation $conversation)
    {
        $user = $request->user();

        // authorization: ensure user is participant
        if (!$conversation->users()->where('users.id', $user->id)->exists()) {
            abort(403);
        }

        $messages = $conversation->messages()->with('sender')->latest()->paginate(20);

        return response()->json($messages);
    }
}
