<style>
    .relative.inline-block {
        position: relative;
        display: inline-block;
    }

    .relative.inline-block button.flex.items-center.gap-2 {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .relative.inline-block button.flex.items-center.gap-2:hover {
        border-color: #3b82f6;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }

    .relative.inline-block .font-medium.text-sm {
        font-weight: 500;
        font-size: 14px;
        color: #1f2937;
    }

    /* Dropdown muncul di samping */
    .relative.inline-block .absolute.z-50 {
        position: absolute;
        z-index: 50;
        top: 0;
        left: 100%;
        margin-left: 8px;
        width: 180px; /* Lebar dikurangi */
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        padding: 15px; /* Padding dikurangi */
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.3s ease;
    }

    .relative.inline-block .absolute.z-50[x-show="open"] {
        opacity: 1;
        transform: translateX(0);
    }

    .relative.inline-block .mt-3.flex.gap-2 {
        margin-top: 0; /* Margin top dihapus */
        display: flex;
        flex-direction: column; /* Tombol disusun vertikal */
        gap: 8px;
    }

    .relative.inline-block .flex-1.text-center.px-3.py-2.border.rounded {
        flex: 1;
        text-align: center;
        padding: 10px 12px; /* Padding diperbesar */
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: white;
        color: #374151;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .relative.inline-block .flex-1.text-center.px-3.py-2.border.rounded:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        transform: translateY(-1px);
    }

    .relative.inline-block .flex-1.text-center.px-3.py-2.bg-blue-600.text-white.rounded {
        flex: 1;
        text-align: center;
        padding: 10px 12px; /* Padding diperbesar */
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(59, 130, 246, 0.3);
        width: 100%;
    }

    .relative.inline-block .flex-1.text-center.px-3.py-2.bg-blue-600.text-white.rounded:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        opacity: 0.95;
    }

    /* Avatar custom */
    .user-avatar-mini {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 10px;
    }

    /* pastikan badge kecil tidak memecah layout */
    .user-badge-inline img,
    .user-badge-inline svg {
        width: 34px;
        height: 34px;
        vertical-align: middle;
        margin-left: 6px;
    }

    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="{ open: false }" class="relative inline-block">
    <button type="button" @click="open = !open" class="flex items-center gap-2">
        <div class="user-avatar-mini">{{ substr($user->name, 0, 2) }}</div>
        <span class="font-medium text-sm">
            {{ $user->name }}
            <span class="user-badge-inline" aria-hidden="true">
                @include('components.user-badge', ['user' => $user])
            </span>
        </span>
    </button>

    <div x-show="open" @click.away="open = false" x-cloak
        class="absolute z-50 right-0 mt-2 w-64 bg-white border rounded shadow-lg p-3">

        <div class="flex gap-2 flex-col">
            <a href="{{ route('users.show', ['id' => $user->id]) }}"
                class="flex-1 text-center px-3 py-2 border rounded hover:bg-gray-50">Lihat Profil</a>

            @if (auth()->check() && auth()->id() !== $user->id)
                <button type="button" onclick="startConversation({{ $user->id }})"
                    class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded hover:opacity-95">
                    Kirim Pesan
                </button>
            @endif
        </div>
    </div>
</div>
