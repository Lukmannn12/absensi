<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ubah Status Pengajuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded">

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('pengajuan-cuti.update', $cuti->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Karyawan</label>
                        <input type="text" value="{{ $cuti->user->name }}" disabled
                               class="w-full border px-3 py-2 rounded bg-gray-100">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tanggal Cuti</label>
                        <input type="text"
                               value="{{ $cuti->tanggal_mulai }} s/d {{ $cuti->tanggal_selesai }}"
                               disabled class="w-full border px-3 py-2 rounded bg-gray-100">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Alasan</label>
                        <textarea disabled class="w-full border px-3 py-2 rounded bg-gray-100">{{ $cuti->alasan }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Status</label>
                        <select name="status" class="w-full border px-3 py-2 rounded" required>
                            <option value="pending" {{ $cuti->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ $cuti->status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ $cuti->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('pengajuan-cuti.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
