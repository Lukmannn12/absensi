<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->role === 'admin' ? 'Manajemen Pengajuan Cuti' : 'Pengajuan Cuti Saya' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">#</th>
                                @if(Auth::user()->role === 'admin')
                                <th class="border px-4 py-2">Nama</th>
                                @endif
                                <th class="border px-4 py-2">Tanggal Mulai</th>
                                <th class="border px-4 py-2">Tanggal Selesai</th>
                                <th class="border px-4 py-2">Durasi</th>
                                <th class="border px-4 py-2">Alasan</th>
                                <th class="border px-4 py-2">Status</th>
                                @if(Auth::user()->role === 'admin')
                                <th class="border px-4 py-2">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                @if(Auth::user()->role === 'admin')
                                <td class="border px-4 py-2">{{ $item->user->name }}</td>
                                @endif
                                <td class="border px-4 py-2">{{
                                    \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                                <td class="border px-4 py-2">{{
                                    \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') }}</td>

                                <td class="border px-4 py-2">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->diffInDays($item->tanggal_selesai) +
                                    1 }} hari
                                </td>
                                <td class="border px-4 py-2">{{ $item->alasan ?? '-' }}</td>
                                <td class="border px-4 py-2 capitalize">
                                    {{ $item->status }}
                                </td>
                                @if(Auth::user()->role === 'admin')
                                <td class="border px-4 py-2">
                                    <a href="{{ route('pengajuan-cuti.edit', $item->id) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'admin' ? 8 : 6 }}"
                                    class="text-center border px-4 py-2 text-gray-500">
                                    Belum ada pengajuan cuti.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>