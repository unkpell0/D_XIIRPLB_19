@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Form Pembayaran</h1>

        <div class="row">
            <!-- Informasi Mobil -->
            <div class="col-md-8">
                <div class="bg-light p-3 rounded shadow-sm">
                    <h3>Detail Mobil</h3>
                    <div class="mb-3">
                        <img src="{{ Storage::url('public/cars/') . $car->image }}" alt="Gambar Mobil" class="img-fluid rounded">
                    </div>
                    <p><strong>Nama:</strong> {{ $car->nama }}</p>
                    <p><strong>Jenis:</strong> {{ $car->tipe }}</p>
                    <p><strong>Nomor Plat:</strong> {{ $car->plat_nomor }}</p>
                    <p><strong>Harga Rental:</strong> Rp{{ number_format($car->rental_price, 0, ',', '.') }}</p>

                    <!-- Durasi Sewa dan Total Pembayaran -->
                    <p><strong>Durasi Sewa:</strong> {{ session('duration') }} Hari</p>
                    <p><strong>Total Pembayaran:</strong> Rp{{ number_format(session('total_payment'), 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="col-md-4">
                <form action="{{ route('user.payment.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <input type="hidden" name="total_payment" value="{{ session('total_payment') }}">

                    <div class="mb-3">
                        <label for="payment_method" class="col-form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="cash">Tunai</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Konfirmasi Rental</button>
                </form>
            </div>
        </div>
    </div>
@endsection
