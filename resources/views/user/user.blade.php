@extends('layouts.app')

@section('title', 'USER | DAFTAR MOBIL')

@section('content')
    <div class="container mt-5">
        <!-- Status Rental Section -->
        <div class="mb-4">
            {{-- <h2 class="text-xl font-bold mb-3">Status Rental Saya</h2> --}}
            @php
                // $activeRentals = Auth::user()->rental()->where('status', 'Dirental')->with('car')->get();
                // $remainingRentals = Auth::user()::MAX_RENTALS - $activeRentals->count();
            @endphp

            <div class="alert {{ $remainingRentals > 0 ? 'alert-info' : 'alert-warning' }}">
                <p>Mobil yang sedang disewa: {{ Auth::user()->getActiveRentalsCount() }} dari
                    {{ Auth::user()::MAX_RENTALS }}</p>
                <p>Sisa kuota rental: {{ Auth::user()->getRemainingRentalsAllowed() }} mobil</p>
            </div>

            @if ($activeRentals->count() > 0)
                <div class="mt-3">
                    <h3 class="font-bold mb-2">Mobil Yang Sedang Dirental:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($activeRentals as $rental)
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

        <!-- History Section -->
        <div class="mb-4">
            <h2 class="text-xl font-bold mb-3">History Rental</h2>
            @php
                $rentalHistory = Auth::user()
                    ->rental()
                    // ->whereIn('status', ['Selesai', 'Dibatalkan'])
                    ->with('car')
                    ->latest()
                    ->get();
            @endphp

            @if ($rentalHistory->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Mobil</th>
                                {{-- <th>Status</th> --}}
                                <th>Durasi</th>
                                <th>Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rentalHistory as $rental)
                                <tr>
                                    <td>{{ $rental->start_date->format('d M Y') }}</td>
                                    <td>{{ $rental->car->nama }}</td>
                                    {{-- <td>{{ $rental->status }}</td> --}}
                                    <td>
                                        @if ($rental->return_date)
                                            {{ $rental->start_date->diffInDays($rental->return_date) }} hari
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ number_format($rental->total_payment, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Belum ada history rental</p>
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

                        {{-- @if ($car->isRentedByUser())
                        <a href="{{ route('rental.returnForm', ['carId' => $car->id]) }}"
                           class="btn btn-warning">Kembalikan</a>
                    @elseif ($activeRentals->count() >= Auth::user()::MAX_RENTALS)
                        <button class="btn btn-secondary" disabled>Kuota Rental Penuh</button>
                    @elseif ($car->count > 0)
                        <a href="{{ route('rental.order', ['carId' => $car->id]) }}"
                           class="btn btn-primary">Rental Sekarang</a>
                    @else
                        <button class="btn btn-secondary" disabled>Stok Habis</button>
                    @endif --}}


                        <!-- Bagian List Mobil -->
                        @if ($car->count > 0)
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
