@extends('layouts.app')

@section('title', 'AYORENT | TAMBAH DATA')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <form action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="formFile" class="form-label">GAMBAR</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image">

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
                                    name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Mobil">
                                <!-- error message untuk title -->
                                @error('nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label class="font-weight-bold">JENIS MOBIL</label>

                                {{-- <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                        name="jenis" value="{{ old('jenis') }}" placeholder="Masukkan jenis Mobil"> --}}

                                <select class="form-select @error('jenis') is-invalid @enderror" name="jenis"
                                     aria-label="Default select example">
                                    <option selected></option>
                                    <option value="LCGC" onclick="setStatus('LCGC')">LCGC</option>
                                    <option value="MPV" onclick="setStatus('MPV')">MPV</option>
                                    <option value="SUV" onclick="setStatus('SUV')">SUV</option>
                                    <option value="LMPV" onclick="setStatus('LMPV')">LMPV</option>
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

                                <select class="form-select @error('merek') is-invalid @enderror" name="merek"
                                     aria-label="Default select example">
                                    <option selected></option>
                                    <option value="Toyota" onclick="setStatus('Toyota')">Toyota</option>
                                    <option value="Daihatsu" onclick="setStatus('Daihatsu')">Daihatsu</option>
                                    <option value="Honda" onclick="setStatus('Honda')">Honda</option>
                                    <option value="Mitsubishi" onclick="setStatus('Mitsubishi')">Mitsubishi</option>
                                    <option value="Hyundai" onclick="setStatus('Hyundai')">Hyundai</option>
                                    <option value="Suzuki" onclick="setStatus('Suzuki')">Suzuki</option>
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
                                    name="tipe" value="{{ old('tipe') }}" placeholder="Masukkan tipe Mobil">
                                <!-- error message untuk title -->
                                @error('plat_nomor')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label class="font-weight-bold">PLAT NOMOR MOBIL</label>
                                <input type="text" class="form-control @error('plat_nomor') is-invalid @enderror"
                                    name="plat_nomor" value="{{ old('plat_nomor') }}"
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
                                    name="tahun_produksi" value="{{ old('tahun_produksi') }}"
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
                                        PILIH STATUS
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" onclick="setStatus('Tersedia')">Tersedia</a></li>
                                        <li><a class="dropdown-item" onclick="setStatus('TidakTersedia')">Tidak
                                                Tersedia</a></li>
                                    </ul>
                                </div>
                                <input type="hidden" id="statusInput" name="status">

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
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/4.25.0-lts/standard/ckeditor.js"></script> --}}
@endpush
