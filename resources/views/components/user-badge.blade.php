@php
    use Illuminate\Support\Facades\Schema;

    $identifier = $slug ?? null;
    $userId = $user->id ?? null;
    $hasBadge = false;
    $badgeData = null;

    $pickPrimaryFromCollection = function ($collection) {
        return $collection
            ->sortByDesc(function ($b) {
                $pivotTime = $b->pivot->awarded_at ?? ($b->pivot->created_at ?? null);
                return $pivotTime ? strtotime($pivotTime) : 0;
            })
            ->first();
    };

    // load badgeData sama seperti sebelumnya...
    if ($userId) {
        if ($identifier) {
            // ...existing lookup (ke relasi atau DB) - keep as before
            // (copy the same lookup code you already have)
        } else {
            if (method_exists($user, 'badges') && $user->relationLoaded('badges')) {
                $badge = $pickPrimaryFromCollection($user->badges);
                $hasBadge = (bool) $badge;
                $badgeData = $badge;
            } else {
                $badgeRow = \DB::table('user_badges')
                    ->join('badges', 'user_badges.badge_id', '=', 'badges.id')
                    ->where('user_badges.user_id', $userId)
                    ->orderByRaw('COALESCE(user_badges.awarded_at,user_badges.created_at) DESC')
                    ->select('badges.id', 'badges.name', 'badges.icon')
                    ->first();
                $hasBadge = (bool) $badgeRow;
                $badgeData = $badgeRow;
            }
        }
    }

    // Build candidate public URL(s)
    $iconUrl = null;
    if ($hasBadge && !empty($badgeData->icon)) {
        // 1) public/storage/badges/...
        $p1 = public_path('storage/badges/' . $badgeData->icon);
        if (file_exists($p1)) {
            $iconUrl = asset('storage/badges/' . $badgeData->icon);
        } else {
            // 2) public/badges/...
            $p2 = public_path('badges/' . $badgeData->icon);
            if (file_exists($p2)) {
                $iconUrl = asset('badges/' . $badgeData->icon);
            } else {
                // 3) storage/app/public/badges (if you really put it in storage/app/public)
                $p3 = storage_path('app/public/badges/' . $badgeData->icon);
                if (file_exists($p3)) {
                    $iconUrl = asset('storage/badges/' . $badgeData->icon);
                }
            }
        }
    }
@endphp

@if ($hasBadge)
    <span class="inline-flex items-center ml-1 align-middle" aria-hidden="true">
        @if ($iconUrl)
            <img src="{{ $iconUrl }}" alt="" aria-hidden="true"
                style="width:12px;height:12px;display:inline-block;vertical-align:middle;pointer-events:none;" />
        @else
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"
                style="width:12px;height:12px;display:inline-block;vertical-align:middle;fill:#FBBF24;pointer-events:none;">
                <path d="M12 2l2.9 5.88L21 9.27l-4.5 4.38L17.8 21 12 17.77 6.2 21l1.3-7.35L3 9.27l6.1-1.39L12 2z" />
            </svg>
        @endif
    </span>
@endif
