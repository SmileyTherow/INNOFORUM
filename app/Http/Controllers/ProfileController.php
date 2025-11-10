<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        // Load user dengan social links dan relasi lainnya
        $user = User::with([
            'socialLinks' => function($query) {
                $query->where('visible', true)->orderBy('order');
            },
            'questions',
            'comments'
        ])->findOrFail($id);

        // Hitung statistik
        $threadCount = $user->questions->count();
        $commentCount = $user->comments->count();
        $likeCount = $user->totalQuestionLikes();

        return view('profile.show', compact('user', 'threadCount', 'commentCount', 'likeCount'));
    }

    public function edit(Request $request)
    {
        $user = $request->user()->load('socialLinks');
        return view('profile.edit', compact('user'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


}
