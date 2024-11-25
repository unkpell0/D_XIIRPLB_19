@extends('layouts.app')

@section('title', 'ADMIN | HISTORY RENTAL')

@section('content')
<div class="container mt-5">
    <h1 class="text-2xl mb-4">History Rental</h1>

    <div class="card">
        <div class="card-body">
            <form action="" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <select name="user_id" class="form-control">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            @foreach(['Dirental', 'Selesai', 'Dibatalkan'] as $status)
                                <option value="{{ $status }}"
                                        {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Mobil</th>
                            {{-- <th>Status</th> --}}
                            <th>Durasi</th>
                            <th>Total Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentals as $rental)
                            <tr>
                                <td>{{ $rental->id }}</td>
                                <td>{{ $rental->start_date->format('d M Y') }}</td>
                                <td>{{ $rental->user->name }}</td>
                                <td>{{ $rental->car->nama }}</td>
                                {{-- <td>{{ $rental->status }}</td> --}}
                                <td>
                                    @if($rental->return_date)
                                        {{ $rental->start_date->diffInDays($rental->return_date) }} hari
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ number_format($rental->total_payment, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('rental.receipt', ['rentalId' => $rental->id]) }}"
                                       class="btn btn-sm btn-info">
                                        Lihat Receipt
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $rentals->links() }}
        </div>
    </div>
</div>
@endsection
