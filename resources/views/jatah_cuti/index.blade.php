<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Jatah Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('jatah-cuti.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Tambah Jatah Cuti
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="border px-4 py-2">#</th>
                                <th class="border px-4 py-2">Nama Karyawan</th>
                                <th class="border px-4 py-2">Total Cuti</th>
                                <th class="border px-4 py-2">Sisa Cuti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ $item->user->name ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->total_cuti }}</td>
                                    <td class="border px-4 py-2">{{ $item->sisa_cuti }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center border px-4 py-2 text-gray-500">
                                        Tidak ada data jatah cuti.
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
