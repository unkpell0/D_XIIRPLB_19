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
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rental.payment.process', ['rentalId' => $rental->id]) }}" method="POST"
                            id="paymentForm">
                            @csrf
                            <input type="hidden" name="rental_id" value="{{ $rental->id }}">
                            <input type="hidden" name="total_payment" value="{{ $rental->total_payment }}">

                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                <select name="payment_method" id="payment_method" class="form-control" required
                                    onchange="togglePaymentForm()">
                                    <option value="">Pilih metode pembayaran</option>
                                    <option value="bank_transfer">Transfer Bank</option>
                                    <option value="cash">Tunai</option>
                                </select>
                            </div>

                            <!-- Form untuk Transfer Bank -->
                            <div id="bankTransferForm" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Bank</label>
                                    <select name="bank_name" class="form-control">
                                        <option value="bca">BCA</option>
                                        <option value="mandiri">Mandiri</option>
                                        <option value="bni">BNI</option>
                                        <option value="bri">BRI</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Kartu Kredit</label>
                                    <input type="text" name="card_number" class="form-control"
                                        placeholder="XXXX-XXXX-XXXX-XXXX" pattern="\d{4}-\d{4}-\d{4}-\d{4}">
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Expired Date</label>
                                            <input type="text" name="expiry_date" class="form-control"
                                                placeholder="MM/YY" pattern="\d{2}/\d{2}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">CVV</label>
                                            <input type="text" name="cvv" class="form-control" placeholder="XXX"
                                                pattern="\d{3}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama di Kartu</label>
                                    <input type="text" name="card_holder" class="form-control">
                                </div>
                            </div>

                            <!-- Form untuk Pembayaran Tunai -->
                            <div id="cashForm" style="display: none;">
                                <div class="alert alert-info">
                                    <h5>Instruksi Pembayaran Tunai:</h5>
                                    <p>1. Silakan datang ke kantor kami</p>
                                    <p>2. Tunjukkan kode booking: <strong>{{ $rental->id }}</strong></p>
                                    <p>3. Lakukan pembayaran sebesar:
                                        <strong>Rp{{ number_format($rental->total_payment, 0, ',', '.') }}</strong>
                                    </p>
                                    <p>4. Pembayaran harus dilakukan dalam waktu 24 jam</p>
                                </div>
                            </div>

                            <!-- Tombol -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary mb-2">Konfirmasi Pembayaran</button>
                            </div>
                        </form>

                        

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePaymentForm() {
            const paymentMethod = document.getElementById('payment_method').value;
            const bankTransferForm = document.getElementById('bankTransferForm');
            const cashForm = document.getElementById('cashForm');

            // Sembunyikan semua form terlebih dahulu
            bankTransferForm.style.display = 'none';
            cashForm.style.display = 'none';

            // Tampilkan form sesuai metode pembayaran yang dipilih
            if (paymentMethod === 'bank_transfer') {
                bankTransferForm.style.display = 'block';
            } else if (paymentMethod === 'cash') {
                cashForm.style.display = 'block';
            }
        }

        function confirmPrint() {
            if (confirm('Apakah Anda ingin mencetak struk?')) {
                const form = document.getElementById('paymentForm');
                const printInput = document.createElement('input');
                printInput.type = 'hidden';
                printInput.name = 'print_receipt';
                printInput.value = 'true';
                form.appendChild(printInput);
                form.submit();
            }
        }

        // Format nomor kartu otomatis
        document.querySelector('input[name="card_number"]')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '').substring(0,16); // Hapus semua non-digit
            let formattedValue = '';

            for(let i = 0; i < value.length; i++) {
                if(i > 0 && i % 4 === 0) {
                    formattedValue += '-';
                }
                formattedValue += value[i];
            }

            e.target.value = formattedValue;
        });

        // Format expired date otomatis
        document.querySelector('input[name="expiry_date"]')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '').substring(0,4);
            if(value.length > 2) {
                value = value.substring(0,2) + '/' + value.substring(2);
            }
            e.target.value = value;
        });

        // Format CVV (hanya angka, maksimal 3 digit)
        document.querySelector('input[name="cvv"]')?.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0,3);
        });
    </script>
    @endpush
@endsection
