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
                        <img src="{{ Storage::url('public/cars/') . $rental->car->image }}" alt="Gambar Mobil"
                            class="img-fluid rounded">
                    </div>
                    <p><strong>Nama:</strong> {{ $rental->car->nama }}</p>
                    <p><strong>Jenis:</strong> {{ $rental->car->tipe }}</p>
                    <p><strong>Nomor Plat:</strong> {{ $rental->car->plat_nomor }}</p>
                    <p><strong>Harga Rental:</strong> Rp{{ number_format($rental->car->rental_price, 0, ',', '.') }}</p>

                    <!-- Durasi Sewa dan Total Pembayaran -->
                    <p><strong>Durasi Sewa:</strong> {{ $rental->duration }} Hari</p>
                    <p><strong>Total Pembayaran:</strong> Rp{{ number_format($rental->total_payment, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="col-md-4">
                <form action="{{ route('rental.payment.process', ['rentalId' => $rental->id]) }}" method="POST"
                    id="paymentForm">
                    @csrf
                    <input type="hidden" name="rental_id" value="{{ $rental->id }}">
                    <input type="hidden" name="total_payment" value="{{ $rental->total_payment }}">

                    <div class="mb-3">
                        <label for="payment_method" class="col-form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="cash">Tunai</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-success" onclick="confirmPrint()">Cetak Struk</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmPrint() {
                if (confirm('Apakah Anda ingin mencetak struk?')) {
                    // Jika user memilih OK, submit form dengan parameter print=true
                    const form = document.getElementById('paymentForm');
                    const printInput = document.createElement('input');
                    printInput.type = 'hidden';
                    printInput.name = 'print_receipt';
                    printInput.value = 'true';
                    form.appendChild(printInput);
                    form.submit();
                } else {
                    // Jika user memilih Cancel, submit form tanpa parameter print
                    // document.getElementById('paymentForm').submit();
                }
            }


        </script>
    @endpush
@endsection
