@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h1>Anda Berhasil Merental Mobil!</h1>
        <p>Mobil dengan nama {{ $rental->car->name }} berhasil dirental selama {{ $rental->duration }} hari.</p>
        <p>Harap kembali pada tanggal <strong>{{ $rental->return_date }}</strong> untuk pengembalian mobil.</p>

        <div class="alert alert-success">
            Pembayaran berhasil dikonfirmasi!
        </div>
        <div class="flex flex-col mx-auto space-y-2 w-48">
            <a href="{{ route('rental.receipt', ['rentalId' => $rental->id]) }}" class="btn btn-primary">Cetak Struk</a>

            <a href="{{ route('user') }}" class="btn btn-primary mt-4">Kembali ke Menu Utama</a>
        </div>
    </div>


    @push('scripts')
        <script>
            window.onload = function() {
                setTimeout(function() {
                    window.location.href = "{{ route('rental.success', ['rentalId' => $rental->id]) }}";
                }, 5000); // Tunggu 3 detik sebelum diarahkan
            };
        </script>
    @endpush
@endsection
