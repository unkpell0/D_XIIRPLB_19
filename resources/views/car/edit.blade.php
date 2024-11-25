@extends('layouts.app')

@section('title', 'AYORENT | EDIT DATA')
@section('content')
    <div class="container mx-auto mb-10">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg">
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Data Mobil</h2>
                    <form action="{{ route('car.update', $car->id) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/cars/' . $car->image) }}" alt="Car Image"
                                class="inline-block h-32 w-auto object-cover rounded-lg shadow-sm">
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                            <input type="file" id="image" name="image"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 @error('image') @enderror">
                            @error('image')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-row w-full space-x-4">
                            <div class="w-full">
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama', $car->nama) }}"
                                    placeholder="Masukkan Nama Mobil"
                                    class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-500 placeholder:italic placeholder:pl-2  @error('nama') @enderror">
                                @error('nama')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="count" class="block text-sm font-medium text-gray-700">Jumlah Mobil</label>
                                <input type="number" id="count" name="count" value="{{ old('count', $car->count) }}"
                                    placeholder="Masukkan jumlah mobil"
                                    class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('count') placeholder:ml-2 @enderror">
                                @error('count')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-row w-full space-x-4">
                            <div class="w-full">
                                <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis Mobil</label>
                                <select id="jenis" name="jenis"
                                    class="mt-2 h-9 block w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('jenis') @enderror">
                                    <option value="" {{ old('jenis', $car->jenis) == '' ? 'selected' : '' }} disabled>
                                        Pilih Jenis Mobil</option>
                                    <option value="LCGC" {{ old('jenis', $car->jenis) == 'LCGC' ? 'selected' : '' }}>LCGC
                                    </option>
                                    <option value="MPV" {{ old('jenis', $car->jenis) == 'MPV' ? 'selected' : '' }}>MPV
                                    </option>
                                    <option value="SUV" {{ old('jenis', $car->jenis) == 'SUV' ? 'selected' : '' }}>SUV
                                    </option>
                                    <option value="LMPV" {{ old('jenis', $car->jenis) == 'LMPV' ? 'selected' : '' }}>LMPV
                                    </option>
                                </select>
                                @error('jenis')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="merek" class="block text-sm font-medium text-gray-700">Merek Mobil</label>
                                <select id="merek" name="merek"
                                    class="mt-2 h-9 block w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('merek') @enderror">
                                    <option value="" {{ old('merek', $car->merek) == '' ? 'selected' : '' }}
                                        disabled>Pilih Merek Mobil</option>
                                    <option value="Toyota" {{ old('merek', $car->merek) == 'Toyota' ? 'selected' : '' }}>
                                        Toyota</option>
                                    <option value="Daihatsu"
                                        {{ old('merek', $car->merek) == 'Daihatsu' ? 'selected' : '' }}>Daihatsu</option>
                                    <option value="Honda" {{ old('merek', $car->merek) == 'Honda' ? 'selected' : '' }}>
                                        Honda</option>
                                    <option value="Mitsubishi"
                                        {{ old('merek', $car->merek) == 'Mitsubishi' ? 'selected' : '' }}>Mitsubishi
                                    </option>
                                    <option value="Hyundai" {{ old('merek', $car->merek) == 'Hyundai' ? 'selected' : '' }}>
                                        Hyundai</option>
                                    <option value="Suzuki" {{ old('merek', $car->merek) == 'Suzuki' ? 'selected' : '' }}>
                                        Suzuki</option>
                                </select>
                                @error('merek')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-row w-full space-x-4">
                            <div class="w-full">
                                <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe Mobil</label>
                                <input type="text" id="tipe" name="tipe" value="{{ old('tipe', $car->tipe) }}"
                                    placeholder="Masukkan Tipe Mobil"
                                    class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipe') @enderror">
                                @error('tipe')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="plat_nomor" class="block text-sm font-medium text-gray-700">Plat Nomor
                                    Mobil</label>
                                <input type="text" id="plat_nomor" name="plat_nomor"
                                    value="{{ old('plat_nomor', $car->plat_nomor) }}"
                                    placeholder="Masukkan Plat Nomor Mobil"
                                    class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('plat_nomor') @enderror">
                                @error('plat_nomor')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-row w-full space-x-4">
                            <div class="w-full">
                                <label for="tahun_produksi" class="block text-sm font-medium text-gray-700">Tahun Produksi
                                    Mobil</label>
                                <input type="text" id="tahun_produksi" name="tahun_produksi"
                                    value="{{ old('tahun_produksi', $car->tahun_produksi) }}"
                                    placeholder="Masukkan Tahun Produksi"
                                    class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tahun_produksi') @enderror">
                                @error('tahun_produksi')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="rental_price" class="block text-sm font-medium text-gray-700">Harga Sewa (per
                                    hari)</label>
                                <input type="number" id="rental_price" name="rental_price"
                                    value="{{ old('rental_price', $car->rental_price) }}"
                                    placeholder="Masukkan Harga Sewa per Hari"
                                    class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('rental_price') @enderror">
                                @error('rental_price')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') @enderror">
                                <option value="" {{ old('status', $car->status) == '' ? 'selected' : '' }} disabled>
                                    Pilih Status</option>
                                <option value="tersedia"
                                    {{ old('status', $car->status) == 'tersedia' ? 'selected' : '' }}>
                                    Tersedia</option>
                                <option value="maintenance"
                                    {{ old('status', $car->status) == 'maintenance' ? 'selected' : '' }}>Maintenance
                                </option>
                                <option value="disewa" {{ old('status', $car->status) == 'disewa' ? 'selected' : '' }}>
                                    Disewa</option>
                            </select>
                            @error('status')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        <div class="w-full">
                            <label for="note" class="block text-sm font-medium text-gray-700">Catatan Mobil</label>
                            <input type="text" id="note" name="note" value="{{ old('note', $car->note) }}"
                                placeholder="Masukkan Catatan untuk mobil"
                                class="mt-2 block h-9 w-full text-sm text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('note') placeholder:ml-2 @enderror">
                            @error('note')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <button type="submit"
                                class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-blue-600">Update</button>
                            <button type="reset"
                                class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-yellow-600">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
