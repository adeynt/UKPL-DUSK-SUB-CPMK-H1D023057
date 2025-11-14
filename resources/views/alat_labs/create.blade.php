<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Alat Lab') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <a href="{{ route('alat-lab.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 mb-4 inline-block">
                    &larr; Kembali ke Daftar Alat
                </a>

                <form action="{{ route('alat-lab.store') }}" method="POST">
                    @csrf

                    {{-- Kode Alat --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="kode-input">Kode Alat <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_alat" id="kode-input"
                               value="{{ old('kode_alat') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2
                                    focus:ring-indigo-500 focus:border-indigo-500 @error('kode_alat') border-red-500 @enderror"
                               dusk="kode-input" required>
                        @error('kode_alat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Alat --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="nama-input">Nama Alat <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_alat" id="nama-input"
                               value="{{ old('nama_alat') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2
                                    focus:ring-indigo-500 focus:border-indigo-500 @error('nama_alat') border-red-500 @enderror"
                               dusk="nama-input" required>
                        @error('nama_alat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="lokasi-input">Lokasi (Opsional)</label>
                        <input type="text" name="lokasi" id="lokasi-input"
                               value="{{ old('lokasi') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2
                                    focus:ring-indigo-500 focus:border-indigo-500 @error('lokasi') border-red-500 @enderror"
                               dusk="lokasi-input">
                        @error('lokasi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="jumlah-input">Jumlah <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah" id="jumlah-input"
                               value="{{ old('jumlah') }}"
                               min="0"
                               class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2
                                    focus:ring-indigo-500 focus:border-indigo-500 @error('jumlah') border-red-500 @enderror"
                               dusk="jumlah-input" required>
                        @error('jumlah')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kondisi --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1" for="kondisi-select">Kondisi <span class="text-red-500">*</span></label>
                        <select name="kondisi" id="kondisi-select"
                                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2
                                        focus:ring-indigo-500 focus:border-indigo-500 @error('kondisi') border-red-500 @enderror"
                                dusk="kondisi-select" required>
                            {{-- Mempertahankan nilai old('kondisi') jika ada --}}
                            @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $k)
                                <option value="{{ $k }}" @selected(old('kondisi') == $k)>
                                    {{ $k }}
                                </option>
                            @endforeach
                        </select>
                        @error('kondisi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Simpan --}}
                    <x-primary-button type="submit" dusk="submit-create">
                        Simpan Data Alat
                    </x-primary-button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>