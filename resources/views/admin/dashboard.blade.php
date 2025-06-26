<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white shadow rounded p-4 transform transition duration-200 hover:scale-105 hover:shadow-lg cursor-pointer">
                <div class="text-gray-600">Total Karyawan</div>
                <div class="text-2xl font-bold">{{ $totalKaryawan }}</div>
            </div>
            <div class="bg-blue-100 shadow rounded p-4 transform transition duration-200 hover:scale-105 hover:shadow-lg cursor-pointer">
                <div class="text-gray-600">Absen Hari Ini</div>
                <div class="text-2xl font-bold">{{ $absenHariIni }}</div>
            </div>
            <div class="bg-green-100 shadow rounded p-4 transform transition duration-200 hover:scale-105 hover:shadow-lg cursor-pointer">
                <div class="text-gray-600">Sudah Pulang</div>
                <div class="text-2xl font-bold">{{ $sudahPulang }}</div>
            </div>
            <div class="bg-yellow-100 shadow rounded p-4 transform transition duration-200 hover:scale-105 hover:shadow-lg cursor-pointer">
                <div class="text-gray-600">Belum Pulang</div>
                <div class="text-2xl font-bold">{{ $belumPulang }}</div>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Timeline Absensi Terbaru</h3>
            <ul class="space-y-3">
                @forelse ($timeline as $item)
                    <li class="border-b pb-2 hover:bg-gray-50 transition-all duration-200 rounded px-2 py-1 cursor-pointer">
                        <div class="text-sm text-gray-700">
                            <span class="font-semibold">{{ $item->user->name }}</span>
                            absen pada <strong>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</strong>
                        </div>
                        <div class="text-xs text-gray-500">
                            Jam Masuk: {{ $item->jam_masuk ?? '-' }} |
                            Jam Pulang: {{ $item->jam_pulang ?? '-' }}
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500">Belum ada data absensi.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
