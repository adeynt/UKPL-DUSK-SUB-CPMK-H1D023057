<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Alat Lab') }}
        </h2>

        <x-primary-button 
            dusk="create-alatlab-button"
            onclick="window.location='{{ route('alat-lab.create') }}'">
            {{ __('Tambah Alat') }}
        </x-primary-button>

    </div>
</x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg shadow-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300 text-left text-sm">
                        <thead class="bg-gray-50 text-gray-700 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 border-r">Kode</th>
                                <th class="px-4 py-3 border-r">Nama</th>
                                <th class="px-4 py-3 border-r">Lokasi</th>
                                <th class="px-4 py-3 border-r">Jumlah</th>
                                <th class="px-4 py-3 border-r">Kondisi</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($alat as $a)
                                <tr class="hover:bg-gray-100 transition duration-150 ease-in-out">
                                    <td class="px-4 py-3 border-r">{{ $a->kode_alat }}</td>
                                    <td class="px-4 py-3 border-r">{{ $a->nama_alat }}</td>
                                    <td class="px-4 py-3 border-r">{{ $a->lokasi }}</td>
                                    <td class="px-4 py-3 border-r">{{ $a->jumlah }}</td>
                                    <td class="px-4 py-3 border-r">
                                        {{-- Style kondisi agar lebih visual --}}
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($a->kondisi == 'Baik') bg-green-100 text-green-800
                                            @elseif($a->kondisi == 'Rusak Ringan') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $a->kondisi }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center whitespace-nowrap">
                                        <a href="{{ route('alat-lab.edit', $a) }}"
                                            dusk="edit-alatlab-{{ $a->id }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium mr-3">
                                            Edit
                                        </a>

                                        <form action="{{ route('alat-lab.destroy', $a) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            {{-- Mengubah konfirmasi menjadi lebih spesifik --}}
                                            <button type="submit"
                                                dusk="delete-alatlab-{{ $a->id }}"
                                                class="text-red-600 hover:text-red-900 font-medium"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data alat {{ $a->nama_alat }} ({{ $a->kode_alat }})?')">
                                                Hapus
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-gray-500 bg-white">
                                        Belum ada data alat laboratorium yang tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $alat->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>