<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
            @endif

            @php
            $today = \Carbon\Carbon::today()->toDateString();
            $userTodayAbsensi = $data->where('user_id', Auth::id())->firstWhere('tanggal', $today);
            @endphp

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    @php
                    $currentTime = \Carbon\Carbon::now();
                    $startTime = \Carbon\Carbon::createFromTime(8, 30);
                    $endTime = \Carbon\Carbon::createFromTime(17, 30);
                    $isWithinTime = $currentTime->between($startTime, $endTime);
                    @endphp

                    <div class="text-sm text-gray-500 mb-2">
                        Waktu absensi: <span class="font-semibold">08:30 - 17:30</span><br>
                        Sekarang: <span id="current-time" class="font-mono">--:--:--</span>
                    </div>
                    @if (!$userTodayAbsensi)
                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded text-white {{ $isWithinTime ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed' }}"
                            {{ $isWithinTime ? '' : 'disabled' }}>
                            Absen Masuk Hari Ini
                        </button>
                    </form>
                    @elseif ($userTodayAbsensi && !$userTodayAbsensi->jam_pulang)
                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded text-white {{ $isWithinTime ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-400 cursor-not-allowed' }}"
                            {{ $isWithinTime ? '' : 'disabled' }}>
                            Absen Pulang Hari Ini
                        </button>
                    </form>
                    @else
                    <div class="text-gray-500">Anda sudah absen lengkap hari ini.</div>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Jam Masuk</th>
                                <th class="border px-4 py-2">Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $item->user->name }}</td>
                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y')
                                    }}</td>
                                <td class="border px-4 py-2">{{ $item->jam_masuk ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->jam_pulang ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-2 text-center text-gray-500">Tidak ada data
                                    absensi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function updateTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
    }

    // Jalankan saat pertama kali load
    updateTime();

    // Update setiap detik
    setInterval(updateTime, 1000);
    </script>
</x-app-layout>