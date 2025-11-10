@php
    $types = [
        'instagram' => 'Instagram',
        'github' => 'GitHub',
        'facebook' => 'Facebook',
        'linkedin' => 'LinkedIn',
        'website' => 'Website',
        'twitter' => 'Twitter',
        'stackoverflow' => 'StackOverflow',
        'devto' => 'Dev.to',
        'codepen' => 'CodePen',
        'dribbble' => 'Dribbble',
        'behance' => 'Behance',
        'medium' => 'Medium',
        'kaggle' => 'Kaggle',
        'gitlab' => 'GitLab',
        'bitbucket' => 'Bitbucket',
        'indeed' => 'Indeed',
        'glassdoor' => 'Glassdoor',
        'angelist' => 'AngelList',
        'researchgate' => 'ResearchGate',
        'scholar' => 'Google Scholar',
        'youtube' => 'YouTube',
        'tiktok' => 'TikTok',
        'threads' => 'Threads',
        'pinterest' => 'Pinterest',
        'snapchat' => 'Snapchat',
        'reddit' => 'Reddit',
        'telegram' => 'Telegram',
        'whatsapp' => 'WhatsApp',
        'discord' => 'Discord',
        'twitch' => 'Twitch',
        'other' => 'Other',
    ];
@endphp

<div class="space-y-2">
    <label class="block text-sm font-medium text-gray-700">Social Links (opsional — maksimal 3)</label>
    <p class="text-xs text-gray-500 mb-2">Pilih jenis dan masukkan URL (mis. github.com/username). Saya akan menambahkan https:// jika tidak ada.</p>

    @php
        // prepare 3 rows, prefilling from $socialLinks if present
        $existing = $socialLinks->values() ?? collect();
        for ($i = 0; $i < 3; $i++) {
            $rows[$i] = $existing->get($i) ? $existing->get($i)->toArray() : ['type' => '', 'url' => '', 'label' => '', 'order' => $i, 'visible' => true];
        }
    @endphp

    <form action="{{ route('profile.social-links.update') }}" method="POST">
        @csrf
        @method('PATCH')

        @for ($i = 0; $i < 3; $i++)
            @php $row = old("links.$i", $rows[$i]); @endphp

            <div class="flex gap-2 items-center">
                <select name="links[{{ $i }}][type]" class="border rounded px-2 py-1">
                    <option value="">-- Pilih tipe --</option>
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}" @if(($row['type'] ?? '') === $key) selected @endif>{{ $label }}</option>
                    @endforeach
                </select>

                <input
                    type="text"
                    name="links[{{ $i }}][url]"
                    value="{{ $row['url'] ?? '' }}"
                    class="border rounded px-2 py-1 flex-1"
                    placeholder="contoh: github.com/username atau https://github.com/username"
                />

                <input
                    type="text"
                    name="links[{{ $i }}][label]"
                    value="{{ $row['label'] ?? '' }}"
                    class="border rounded px-2 py-1 w-48"
                    placeholder="Label (opsional, mis. Portofolio)"
                />

                <button type="button" onclick="this.closest('div').querySelector('input[name*=\'url\']').value=''; this.closest('div').querySelector('input[name*=\'label\']').value=''; this.closest('div').querySelector('select').value='';" class="text-sm text-red-600">Clear</button>
            </div>
        @endfor

        <div class="mt-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan link</button>
        </div>
    </form>
</div>
