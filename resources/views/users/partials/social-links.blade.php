{{-- Partial to show social links on public user profile. Use where you render user profile --}}
@php
    // emoji/icon map
    $iconMap = [
        'instagram' => '📸',
        'github' => '🐙',
        'facebook' => '📘',
        'linkedin' => '💼',
        'website' => '🌐',
        'twitter' => '🐦',
        'stackoverflow' => '💡',
        'devto' => '✍️',
        'codepen' => '🖌️',
        'dribbble' => '🎨',
        'behance' => '🎭',
        'medium' => '📝',
        'kaggle' => '📊',
        'gitlab' => '🦊',
        'bitbucket' => '🗂️',
        'indeed' => '📄',
        'glassdoor' => '🏢',
        'angelist' => '🚀',
        'researchgate' => '📚',
        'scholar' => '🎓',
        'youtube' => '▶️',
        'tiktok' => '🎵',
        'threads' => '🧵',
        'pinterest' => '📌',
        'snapchat' => '👻',
        'reddit' => '👽',
        'telegram' => '✉️',
        'whatsapp' => '📱',
        'discord' => '💬',
        'twitch' => '🎮',
        'other' => '🔗',
    ];
@endphp

@if($user->socialLinks->isNotEmpty())
    <div class="mt-4">
        <h3 class="text-sm font-semibold text-gray-700">Links</h3>
        <ul class="mt-2 space-y-1">
            @foreach($user->socialLinks as $link)
                @if($link->visible)
                    @php
                        $icon = $iconMap[$link->type] ?? '🔗';
                        $label = $link->label ?: parse_url($link->url, PHP_URL_HOST) . (parse_url($link->url, PHP_URL_PATH) ? parse_url($link->url, PHP_URL_PATH) : '');
                    @endphp
                    <li>
                        <a class="inline-flex items-center gap-2 text-blue-600 hover:underline" href="{{ $link->url }}" target="_blank" rel="noopener">
                            <span class="text-lg">{{ $icon }}</span>
                            <span>{{ $label }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
