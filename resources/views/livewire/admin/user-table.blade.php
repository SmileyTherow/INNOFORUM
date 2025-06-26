<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
        <div class="mb-2 md:mb-0">
            <label>
                <span class="mr-2">Show</span>
                <select wire:model="perPage" class="border rounded px-2 py-1">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="ml-2">entries</span>
            </label>
        </div>
        <div>
            <input type="text" wire:model.debounce.500ms="search" placeholder="Cari nama, email, NIM/NIK..." class="border rounded px-2 py-1" />
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border border-gray-300">#</th>
                    <th class="py-2 px-4 border border-gray-300 text-left">Nama</th>
                    <th class="py-2 px-4 border border-gray-300 text-left">Email</th>
                    <th class="py-2 px-4 border border-gray-300 text-left">NIM/NIGM</th>
                    <th class="py-2 px-4 border border-gray-300 text-left">Role</th>
                    <th class="py-2 px-4 border border-gray-300 text-left">Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr class="{{ $i%2 == 0 ? 'bg-gray-50' : '' }}">
                    <td class="py-2 px-4 border border-gray-300">{{ ($users->currentPage()-1)*$users->perPage() + $i + 1 }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $user->name }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $user->email }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $user->username }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $user->role }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $user->created_at->format('Y-m-d') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-2 px-4 border border-gray-300 text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 flex flex-col md:flex-row md:justify-between md:items-center gap-2">
        <div>
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>