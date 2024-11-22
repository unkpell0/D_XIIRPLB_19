@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>Anda Berhasil Merental Mobil!</h1>
    <p>Mobil dengan nama {{ $rental->car->name }} berhasil dirental selama {{ $rental->duration }} hari.</p>
    <p>Harap kembali pada tanggal <strong>{{ $rental->return_date->format('d M Y') }}</strong> untuk pengembalian mobil.</p>
    <a href="{{ route('user') }}" class="btn btn-primary mt-4">Kembali ke Menu Utama</a>
</div>
@endsection
