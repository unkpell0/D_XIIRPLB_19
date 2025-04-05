@extends('layouts.admin')

@section('title', 'ADMIN | TAMBAH DATA')
@section('content')
<div class="container mx-auto mb-10 px-4 lg:px-0">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg">
            <div class="p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Data Mobil</h2>
                <form action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Input Gambar --}}
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('image') is-invalid @enderror">
                        @error('image')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama dan Jumlah Mobil --}}
                    <div class="flex flex-col lg:flex-row w-full space-y-4 lg:space-y-0 lg:space-x-4">
                        <div class="w-full">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                placeholder="Masukkan Nama Mobil"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('nama') is-invalid @enderror">
                            @error('nama')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="count" class="block text-sm font-medium text-gray-700">Jumlah Mobil</label>
                            <input type="number" id="count" name="count" value="{{ old('count') }}"
                                placeholder="Masukkan Jumlah Mobil"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('count') is-invalid @enderror">
                            @error('count')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Jenis dan Merek Mobil --}}
                    <div class="flex flex-col lg:flex-row w-full space-y-4 lg:space-y-0 lg:space-x-4">
                        <div class="w-full">
                            <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis Mobil</label>
                            <select id="jenis" name="jenis"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('jenis') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Jenis Mobil</option>
                                <option value="LCGC">LCGC</option>
                                <option value="MPV">MPV</option>
                                <option value="SUV">SUV</option>
                                <option value="LMPV">LMPV</option>
                            </select>
                            @error('jenis')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="merek" class="block text-sm font-medium text-gray-700">Merek Mobil</label>
                            <select id="merek" name="merek"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('merek') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Merek Mobil</option>
                                <option value="Toyota">Toyota</option>
                                <option value="Daihatsu">Daihatsu</option>
                                <option value="Honda">Honda</option>
                                <option value="Mitsubishi">Mitsubishi</option>
                                <option value="Hyundai">Hyundai</option>
                                <option value="Suzuki">Suzuki</option>
                            </select>
                            @error('merek')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Tipe dan Plat Nomor --}}
                    <div class="flex flex-col lg:flex-row w-full space-y-4 lg:space-y-0 lg:space-x-4">
                        <div class="w-full">
                            <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe Mobil</label>
                            <input type="text" id="tipe" name="tipe" value="{{ old('tipe') }}"
                                placeholder="Masukkan Tipe Mobil"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('tipe') is-invalid @enderror">
                            @error('tipe')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="plat_nomor" class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                            <input type="text" id="plat_nomor" name="plat_nomor" value="{{ old('plat_nomor') }}"
                                placeholder="Masukkan Plat Nomor"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('plat_nomor') is-invalid @enderror">
                            @error('plat_nomor')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Harga Sewa --}}
                    <div class="flex flex-col lg:flex-row w-full space-y-4 lg:space-y-0 lg:space-x-4">
                        <div class="w-full">
                            <label for="rental_price" class="block text-sm font-medium text-gray-700">Harga Sewa</label>
                            <input type="number" id="rental_price" name="rental_price" value="{{ old('rental_price') }}"
                                placeholder="Masukkan Harga Sewa (per hari)"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('rental_price') is-invalid @enderror">
                            @error('rental_price')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tahun Produksi --}}
                        <div class="w-full">
                            <label for="tahun_produksi" class="block text-sm font-medium text-gray-700">Tahun Produksi</label>
                            <input type="number" id="tahun_produksi" name="tahun_produksi" value="{{ old('tahun_produksi') }}"
                                placeholder="Masukkan Tahun Produksi"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('tahun_produksi') is-invalid @enderror">
                            @error('tahun_produksi')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700">Catatan</label>
                        <textarea id="note" name="note" rows="3"
                            class="mt-2 block w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-xs focus:ring-blue-500 focus:border-blue-500 @error('note') is-invalid @enderror"
                            placeholder="Masukkan Catatan">{{ old('note') }}</textarea>
                        @error('note')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Submit dan Reset --}}
                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-sm hover:bg-blue-600">
                            Simpan
                        </button>
                        <button type="reset"
                            class="bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-sm hover:bg-gray-400">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
