@extends('layouts.app')

@section('title', 'AYORENT | TAMPILAN DATA')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <h1 class="text-center mb-4">Daftar Mobil</h1>

            <!-- Link untuk Tambah Mobil -->
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('car.create') }}" class="btn btn-success">Tambah Mobil</a>
            </div>

            @foreach ($cars as $car)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="{{ asset('storage/cars/' . $car->image) }}" class="card-img-center bg-contain rounded-md" alt="{{ $car->nama }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->nama }}</h5>
                            <p class="card-text"><strong>Merek:</strong> {{ $car->merek }}</p>
                            <p class="card-text"><strong>Jenis:</strong> {{ $car->jenis }}</p>
                            <p class="card-text"><strong>Tipe:</strong> {{ $car->tipe }}</p>
                            <p class="card-text"><strong>Plat Nomor:</strong> {{ $car->plat_nomor }}</p>
                            <p class="card-text"><strong>Jumlah:</strong> {{ $car->count }}</p>
                            {{-- <p class="card-text"><strong>Status:</strong>
                                <span class="badge bg-{{ $car->status == 'tersedia' ? 'success' : ($car->status == 'maintenance' ? 'warning' : 'danger') }}">
                                    {{ $car->status }}
                                </span>
                            </p> --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('car.edit', $car->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('car.destroy', $car->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $cars->links() }}
        </div>
    </div>
@endsection
