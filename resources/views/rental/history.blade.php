@extends('layouts.app')]

@section('title', 'HISTORY | USER')

@section('content')
<!-- History Section -->
<div class="mb-4 mx-20">
    <h2 class="text-xl font-bold mb-3">History Rental</h2>
    @php
        $rentalHistory = Auth::user()
            ->rental()
            ->with('car')
            ->latest()
            ->get();
    @endphp

    @if ($rentalHistory->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Tanggal</th>
                        <th>Mobil</th>
                        <th>Durasi</th>
                        <th>Total Biaya</th>
                        <th>Download struk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentalHistory as $rental)
                        <tr>
                            <td>{{ $rental->user_id }}</td>
                            <td>{{ $rental->start_date->format('d M Y') }}</td>
                            <td>{{ $rental->car->nama }}</td>
                            <td>
                                @if ($rental->return_date)
                                    {{ $rental->start_date->diffInDays($rental->return_date) }} hari
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ number_format($rental->total_payment, 0, ',', '.') }}</td>
                            <td><a href="{{ route('rental.receipt', ['rentalId' => $rental->id]) }}" class="btn btn-primary">Cetak Struk</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Belum ada history rental</p>
    @endif
</div>
@endsection
