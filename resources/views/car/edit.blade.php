@extends('layouts.app')

@section('title', 'AYORENT | EDIT DATA')

@section('content')

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <form action="{{ route('car.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group text-center">
                                <img src="{{ asset('storage/cars/' . $car->image) }}" alt="Car Image"
                                    class="img-thumbnail mb-3" style="width: 150px">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">GAMBAR</label>
                                <input type="file" class="form-control" name="image">

                                {{-- error message untuk title --}}
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- <div class="form-group">
                                <label class="font-weight-bold">GAMBAR</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image">
                            </div> --}}

                            <div class="form-group mt-3">
                                <label class="font-weight-bold">NAMA MOBIL</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ old('nama', $car->nama) }}" placeholder="Masukkan Nama Mobil">
                                <!-- error message untuk title -->
                                @error('nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label class="font-weight-bold">JENIS MOBIL</label>
                                
                                <select class="form-select @error('jenis') is-invalid @enderror" name="jenis"
                                     aria-label="Default select example">
                                    <option value="" {{ old('jenis', $car->jenis) == '' ? 'selected' : '' }}>PILIH JENIS MOBIL</option>
                                    <option value="LCGC" {{ old('jenis', $car->jenis) == 'LCGC' ? 'selected' : '' }}>LCGC</option>
                                    <option value="MPV" {{ old('jenis', $car->jenis) == 'MPV' ? 'selected' : '' }}>MPV</option>
                                    <option value="SUV" {{ old('jenis', $car->jenis) == 'SUV' ? 'selected' : '' }}>SUV</option>
                                    <option value="LMPV" {{ old('jenis', $car->jenis) == 'LMPV' ? 'selected' : '' }}>LMPV</option>
                                </select>

                                <!-- error message untuk title -->
                                @error('jenis')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label class="font-weight-bold">MEREK MOBIL</label>
                                
                                <select class="form-select @error('merek') is-invalid @enderror" name="merek" aria-label="Default select example">
                                    <option value="" {{ old('merek', $car->merek) == '' ? 'selected' : '' }}>PILIH JENIS MOBIL</option>
                                    <option value="Toyota" {{ old('merek', $car->merek) == 'Toyota' ? 'selected' : '' }}>TOYOTA</option>
                                    <option value="Daihatsu" {{ old('merek', $car->merek) == 'Daihatsu' ? 'selected' : '' }}>DAIHATSU</option>
                                    <option value="Honda" {{ old('merek', $car->merek) == 'Honda' ? 'selected' : '' }}>HONDA</option>
                                    <option value="Mitsubishi" {{ old('merek', $car->merek) == 'Mitsubishi' ? 'selected' : '' }}>MITSUBISHI</option>
                                    <option value="Hyundai" {{ old('merek', $car->merek) == 'Hyundai' ? 'selected' : '' }}>HYUNDAI</option>
                                    <option value="Suzuki" {{ old('merek', $car->merek) == 'Suzuki' ? 'selected' : '' }}>SUZUKI</option>
                                </select>
                                

                                <!-- error message untuk title -->
                                @error('merek')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label class="font-weight-bold">TIPE MOBIL</label>
                                <input type="text" class="form-control @error('tipe') is-invalid @enderror"
                                    name="tipe" value="{{ old('tipe', $car->tipe) }}" placeholder="Masukkan tipe Mobil">
                                <!-- error message untuk title -->
                                @error('tipe')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label class="font-weight-bold">PLAT NOMOR MOBIL</label>
                                <input type="text" class="form-control @error('plat_nomor') is-invalid @enderror"
                                    name="plat_nomor" value="{{ old('plat_nomor', $car->plat_nomor) }}"
                                    placeholder="Masukkan Plat Nomor Mobil">
                                <!-- error message untuk title -->
                                @error('plat_nomor')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label class="font-weight-bold">TAHUN PRODUKSI MOBIL</label>
                                <input type="text" class="form-control @error('tahun_produksi') is-invalid @enderror"
                                    name="tahun_produksi" value="{{ old('tahun_produksi', $car->tahun_produksi) }}"
                                    placeholder="Masukkan Tahun Produksi Mobil">
                                <!-- error message untuk title -->
                                @error('tahun_produksi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3 mb-3">
                                <label class="font-weight-bold">STATUS</label>
                                <div class="dropdown mt-2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false" id="statusButton">
                                        {{ old('status', $car->status) }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setStatus('')">PILIH
                                                STATUS</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                onclick="setStatus('Tersedia')">Tersedia</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                onclick="setStatus('Tidak Tersedia')">Tidak Tersedia</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                onclick="setStatus('Dirental')">Dirental</a></li>
                                    </ul>
                                </div>
                                <!-- Input tersembunyi untuk menyimpan nilai status -->
                                <input type="hidden" id="statusInput" name="status"
                                    value="{{ old('status', $car->status) }}">

                                @if ($errors->has('status'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('status') }}
                                    </div>
                                @endif

                            </div>

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function setStatus(status) {
            document.getElementById('statusInput').value = status;

            document.getElementById('statusButton').textContent = status;
        }
        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            // Atur ulang status dropdown dan input tersembunyi ke nilai awal
            const initialStatus = "{{ old('status', $car->status) }}"; // Nilai awal status dari server
            document.getElementById('statusInput').value = initialStatus; // Set hidden input ke nilai awal
            document.getElementById('statusButton').textContent =
                initialStatus; // Set tombol dropdown ke nilai awal
        });
        window.onload = function() {
            let initialStatus = "{{ old('status', $car->status) }}"; // Ambil nilai status dari server

            if (!initialStatus) {
                // Jika tidak ada status yang disimpan, set ke opsi default "PILIH STATUS"
                initialStatus = 'PILIH STATUS';
            }

            // Set tombol dropdown dan input tersembunyi ke status awal
            document.getElementById('statusInput').value = initialStatus === 'PILIH STATUS' ? '' : initialStatus;
            document.getElementById('statusButton').textContent = initialStatus;
        };
    </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
@endpush
