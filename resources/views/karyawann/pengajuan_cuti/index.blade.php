<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Cuti Saya') }}
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

            <div class="mb-4">
                <a href="{{ route('pengajuan-cuti.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Ajukan Cuti Baru
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">#</th>
                                <th class="border px-4 py-2">Tanggal Mulai</th>
                                <th class="border px-4 py-2">Tanggal Selesai</th>
                                <th class="border px-4 py-2">Durasi</th>
                                <th class="border px-4 py-2">Alasan</th>
                                <th class="border px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                            <tr class="hover:bg-gray-50 text-center">
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{
                                    \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                                <td class="border px-4 py-2">{{
                                    \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') }}</td>
                                <td class="border px-4 py-2">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->diffInDays($item->tanggal_selesai) +
                                    1 }} hari
                                </td>
                                <td class="border px-4 py-2">{{ $item->alasan ?? '-' }}</td>
                                <td class="border px-4 py-2">
                                    <span class="capitalize">{{ $item->status }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center border px-4 py-2 text-gray-500">
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