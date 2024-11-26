@extends('layouts.admin')

@section('title', 'ADMIN | TAMPILAN DATA')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <h1 class="text-center mb-4 text-gray-800">Daftar Mobil</h1>

            <!-- Link untuk Tambah Mobil -->
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('car.create') }}" class="btn btn-success">Tambah Mobil</a>
            </div>

            @foreach ($cars as $car)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg rounded-md h-100">
                        <img src="{{ asset('storage/cars/' . $car->image) }}" class="card-img-top img-fluid rounded-t-md" alt="{{ $car->nama }}">
                        <div class="card-body">
                            <h5 class="card-title text-xl font-semibold text-gray-900">{{ $car->nama }}</h5>
                            <p class="card-text"><strong>Merek:</strong> {{ $car->merek }}</p>
                            <p class="card-text"><strong>Jenis:</strong> {{ $car->jenis }}</p>
                            <p class="card-text"><strong>Tipe:</strong> {{ $car->tipe }}</p>
                            <p class="card-text"><strong>Plat Nomor:</strong> {{ $car->plat_nomor }}</p>
                            <p class="card-text"><strong>Jumlah:</strong> {{ $car->count }}</p>

                            <div class="d-flex justify-content-between mt-3">
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
