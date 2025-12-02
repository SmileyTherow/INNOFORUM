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

    public function edit(Request $request)
    {
        $user = $request->user();
        $socialLinks = $user->socialLinks()->get();

        return view('profile.edit', compact('user', 'socialLinks'));
    }

    public function update(UpdateSocialLinksRequest $request)
    {
        $user = $request->user();
        $links = $request->input('links', []);

        $user->socialLinks()->delete();

        foreach ($links as $i => $link) {
            if (empty($link['url'])) {
                continue;
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
