@php
    $existing = ($user->socialLinks ?? collect())->values();
    for ($i = 0; $i < 3; $i++) {
        $rows[$i] = $existing->get($i) ? $existing->get($i)->toArray() : ['url' => '', 'label' => '', 'order' => $i, 'visible' => true];
    }
@endphp

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700">Media Sosial & Links (opsional — maksimal 3)</label>
    <p class="text-xs text-gray-500 mb-3">Masukkan URL atau username (contoh: github.com/username atau @username). Sistem akan menambahkan https:// jika perlu.</p>

    @for ($i = 0; $i < 3; $i++)
        @php $row = old("links.$i", $rows[$i]); @endphp

        <div class="flex gap-2 items-center mb-2">
            <input
                type="text"
                name="links[{{ $i }}][url]"
                value="{{ $row['url'] ?? '' }}"
                class="border rounded px-2 py-1 flex-1"
                placeholder="URL atau username (mis. github.com/username atau @username)"
            />

            <input
                type="text"
                name="links[{{ $i }}][label]"
                value="{{ $row['label'] ?? '' }}"
                class="border rounded px-2 py-1 w-48"
                placeholder="Label (opsional, mis. Portofolio)"
            />

            <button type="button" onclick="this.closest('div').querySelector('input[name*=\'url\']').value=''; this.closest('div').querySelector('input[name*=\'label\']').value='';" class="text-sm text-red-600">Clear</button>
        </div>
    @endfor
</div>
