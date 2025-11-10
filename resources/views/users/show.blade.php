@if (auth()->check() && auth()->id() !== $user->id)
    {{-- AJAX button (better UX) --}}
    <button onclick="startConversation({{ $user->id }})" class="px-4 py-2 bg-blue-600 text-white rounded">
        Kirim Pesan
    </button>

    {{-- optional: fallback non-AJAX form --}}
    <form method="POST" action="{{ route('pesan.conversations.store') }}" class="inline-block ml-2">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <button type="submit" class="px-4 py-2 border rounded">Kirim Pesan (Fallback)</button>
    </form>
@endif
