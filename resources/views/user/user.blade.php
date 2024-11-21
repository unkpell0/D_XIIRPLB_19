@extends('layouts.app')

@section('title', 'USER | DAFTAR MOBIL')

@section('content')
    <div class="container mt-5">
        <h1 class="text-2xl">Daftar Mobil</h1>
        <div class="row">
            @foreach ($cars as $car)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="{{ Storage::url('public/cars/') . $car->image }}" class="card-img-top"
                            alt="{{ $car->nama }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->nama }}</h5>
                            <p class="card-text">{{ $car->merek }} ({{ $car->tahun_produksi }})</p>
                            <p class="card-text">Tipe: {{ $car->tipe }}</p>
                            <p class="card-text">Jenis: {{ $car->jenis }}</p>
                            <p class="card-text">Nomor Plat: {{ $car->plat_nomor }}</p>
                            <p class="card-text"><small class="text-muted">{{ $car->status }}</small></p>

                            @if ($car->status === 'Tersedia')
                                    <a href="{{ route('rental.order', ['carId' => $car->id]) }}"><button type="submit" class="btn btn-primary">RENTAL SEGERA</button></a>
                            @elseif ($car->status === 'Tidak Tersedia')
                                <button class="btn btn-secondary" disabled>TIDAK TERSEDIA</button>
                            @else
                                <button class="btn btn-secondary" disabled>DIRENTAL</button>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
