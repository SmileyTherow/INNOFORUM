<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSocialLinksRequest;
use App\Models\UserSocialLink;
use Illuminate\Http\Request;

class UserSocialLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['edit','update']);
    }

    /**
     * Show edit form for current authenticated user's social links.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $socialLinks = $user->socialLinks()->get();

        // You can include this partial in your profile edit view.
        return view('profile.edit', compact('user', 'socialLinks'));
    }

    /**
     * Update authenticated user's social links.
     * Simple approach: delete all existing links and recreate from input.
     */
    public function update(UpdateSocialLinksRequest $request)
    {
        $user = $request->user();
        $links = $request->input('links', []);

        // Remove all existing (simple and deterministic for <=3 entries).
        $user->socialLinks()->delete();

        // Create new ones preserving order if provided
        foreach ($links as $i => $link) {
            if (empty($link['url'])) {
                continue; // skip blank rows
            }

            $user->socialLinks()->create([
                'type' => $link['type'] ?? 'other',
                'url' => $link['url'],
                'label' => $link['label'] ?? null,
                'order' => $link['order'] ?? $i,
                'visible' => isset($link['visible']) ? (bool) $link['visible'] : true,
            ]);
        }

        return redirect()->back()->with('status', 'Social links updated.');
    }
}
