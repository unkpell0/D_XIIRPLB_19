@extends('layouts.app')

@section('title', 'USER | DAFTAR MOBIL')

@section('content')
    <div class="container mt-5">

        <h3 class="text-center text-5xl text-white font-inter font-bold">Selamat datang, <span class="text-pink-500">{{ Auth::user()->name }}!</span></h3>

        <!-- Status Rental Section -->
        <div class="mb-4 text-color-4 font-bold text-lg">
            @php
                $activeRentalsCount = Auth::user()->getActiveRentalsCount();
                $maxRentals = Auth::user()::MAX_RENTALS;
                $remainingRentalsAllowed = $maxRentals - $activeRentalsCount;
            @endphp

            <div class="alert {{ $remainingRentalsAllowed > 0 ? 'alert-info' : 'alert-warning' }}">
                <p>Mobil yang sedang disewa: {{ $activeRentalsCount }} dari {{ $maxRentals }}</p>
                <p>Sisa kuota rental: {{ $remainingRentalsAllowed }} mobil</p>
            </div>

            @if ($activeRentalsCount > 0)
                <div class="mt-3">
                    <h3 class="font-bold mb-2">Mobil Yang Sedang Dirental:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach (Auth::user()->rental as $rental)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $rental->car->nama }}</h5>
                                    <p>Mulai Rental: {{ $rental->start_date->format('d M Y') }}</p>
                                    <a href="{{ route('rental.returnForm', ['carId' => $rental->car_id]) }}"
                                        class="btn btn-warning mt-2">
                                        Kembalikan Mobil
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Daftar Mobil Yang Tersedia -->
        <h2 class="text-xl font-bold mb-3">Daftar Mobil Tersedia</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($cars as $car)
                <div class="card">
                    <img src="{{ Storage::url('public/cars/') . $car->image }}" class="card-img-top"
                        alt="{{ $car->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->nama }}</h5>
                        <p>{{ $car->merek }} ({{ $car->tahun_produksi }})</p>
                        <p>Tipe: {{ $car->tipe }}</p>
                        <p>Stok Tersedia: {{ $car->count }}</p>

                        @if ($car->isAvailable())
                            <a href="{{ route('rental.order', ['carId' => $car->id]) }}" class="btn btn-primary">Rental
                                Sekarang</a>
                        @else
                            <button class="btn btn-secondary" disabled>Stok Habis</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
