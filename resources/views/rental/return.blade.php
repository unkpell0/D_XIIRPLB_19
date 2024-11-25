@extends('layouts.app')

@section('title', 'Pengembalian Mobil')

@section('content')
    <div class="container mt-5">
        <h1 class="text-2xl mb-4">Form Pengembalian Mobil</h1>
        <form action="{{ route('rental.processReturn', ['carId' => $car->id]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="condition" class="form-label">Kondisi Mobil</label>
                <textarea class="form-control" id="condition" name="condition" rows="3" placeholder="Deskripsikan kondisi mobil"></textarea>
            </div>
            <div class="mb-3">
                <label for="kilometer" class="form-label">Kilometer Akhir</label>
                <input type="number" class="form-control" id="kilometer" name="kilometer" required>
            </div>
            <button type="submit" class="btn btn-success">Kembalikan Mobil</button>
        </form>
    </div>
@endsection
