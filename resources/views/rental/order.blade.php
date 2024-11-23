@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Form Rental Mobil</h1>

        <div class="row">
            <!-- Form Rental -->
            <div class="col-md-8">
                <form id="rentalForm" action="{{ route('rental.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <input type="hidden" id="base_price" value="{{ $car->rental_price ?? 0 }}">

                    <!-- Bagian Form Utama -->
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label">Nama Peminjam</label>
                        <div class="col-md-8">
                            <input type="text" name="name" id="name" value="{{ old('name', $car->name ?? '') }}"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="phone" class="col-md-4 col-form-label">Nomor Telepon</label>
                        <div class="col-md-8">
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="form-control @error('phone') is-invalid @enderror" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label">Email</label>
                        <div class="col-md-8">
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="address" class="col-md-4 col-form-label">Alamat Lengkap</label>
                        <div class="col-md-8">
                            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3"
                                required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="id_card" class="col-md-4 col-form-label">Upload KTP</label>
                        <div class="col-md-8">
                            <input type="file" name="id_card" id="id_card"
                                class="form-control-file @error('id_card') is-invalid @enderror"
                                accept="image/*,application/pdf" required>
                            @error('id_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="duration" class="col-md-4 col-form-label">Durasi Sewa</label>
                        <div class="col-md-8">
                            <select name="duration" id="duration"
                                class="form-control @error('duration') is-invalid @enderror" required>
                                <option value="1" {{ old('duration') == 1 ? 'selected' : '' }}>1 Hari</option>
                                <option value="2" {{ old('duration') == 2 ? 'selected' : '' }}>2 Hari</option>
                                <option value="3" {{ old('duration') == 3 ? 'selected' : '' }}>3 Hari</option>
                                <option value="4" {{ old('duration') == 4 ? 'selected' : '' }}>4 Hari</option>
                                <option value="5" {{ old('duration') == 5 ? 'selected' : '' }}>5 Hari</option>
                                <option value="6" {{ old('duration') == 6 ? 'selected' : '' }}>6 Hari</option>
                                <option value="7" {{ old('duration') == 7 ? 'selected' : '' }}>1 Minggu</option>
                            </select>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Bagian Form Tambahan -->
                    <div id="additionalFields" style="display: none;">
                        <div class="mb-3 row">
                            <label for="return_date" class="col-md-4 col-form-label">Tanggal/Waktu Pengembalian</label>
                            <div class="col-md-8">
                                <input type="datetime-local" name="return_date" id="return_date"
                                    value="{{ old('return_date') }}"
                                    class="form-control @error('return_date') is-invalid @enderror" required>
                                @error('return_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="payment_method" class="col-md-4 col-form-label">Metode Pembayaran</label>
                            <div class="col-md-8">
                                <select name="payment_method" id="payment_method"
                                    class="form-control @error('payment_method') is-invalid @enderror" required>
                                    <option value="bank_transfer"
                                        {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank
                                    </option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai
                                    </option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="total_payment" class="col-md-4 col-form-label">Total Pembayaran</label>
                            <div class="col-md-8">
                                <input type="text" name="total_payment" id="total_payment" class="form-control"
                                    readonly>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary">Bayar</button>
                    </div>
                </form>

            </div>

            <!-- Informasi Mobil -->
            <div class="col-md-4">
                <div class="bg-light p-3 rounded shadow-sm">
                    <h3>Detail Mobil</h3>
                    <div class="mb-3">
                        <img src="{{ Storage::url('public/cars/') . $car->image }}" alt="Gambar Mobil"
                            class="img-fluid rounded">
                    </div>
                    <p><strong>Nama:</strong> {{ $car->nama }}</p>
                    <p><strong>Jenis:</strong> {{ $car->tipe }}</p>
                    <p><strong>Nomor Plat:</strong> {{ $car->plat_nomor }}</p>
                    <p><strong>Harga Rental:</strong> Rp{{ number_format($car->rental_price, 0, ',', '.') }}</p>
                    <p><strong>Status:</strong> {{ $car->status }}</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('rentalForm');
                const additionalFields = document.getElementById('additionalFields');
                const inputs = form.querySelectorAll('input, textarea, select');
                const totalPaymentField = document.getElementById('total_payment');
                const durationField = document.getElementById('duration');
                const returnDateField = document.getElementById('return_date');
                const basePrice = parseInt(document.getElementById('base_price').value) || 0;

                // Update the return date based on the selected duration
                function updateFields() {
                    const duration = parseInt(durationField.value || 1); // Default to 1 day if no value is selected
                    totalPaymentField.value = `Rp${(basePrice * duration).toLocaleString('id-ID')}`;

                    const currentDate = new Date();
                    currentDate.setDate(currentDate.getDate() +
                    duration); // Add the rental duration to the current date

                    const year = currentDate.getFullYear();
                    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                    const day = String(currentDate.getDate()).padStart(2, '0');
                    const hours = String(new Date().getHours()).padStart(2, '0'); // Mengambil jam saat ini
                    const minutes = String(new Date().getMinutes()).padStart(2, '0'); // Mengambil menit saat ini

                    const formattedReturnDate = `${year}-${month}-${day}T${hours}:${minutes}`;
                    returnDateField.value = formattedReturnDate;
                }

                // Call updateFields on page load to set the default return date
                updateFields();

                // Update the return date when the duration is changed
                durationField.addEventListener('change', updateFields);

                // Optional: Store form data to sessionStorage (in case the user navigates away)
                function saveFormData() {
                    inputs.forEach(input => {
                        if (input.name) {
                            sessionStorage.setItem(input.name, input.value);
                        }
                    });
                }

                // Function to load form data from sessionStorage
                function loadFormData() {
                    inputs.forEach(input => {
                        if (input.name) {
                            const savedValue = sessionStorage.getItem(input.name);
                            if (savedValue) {
                                input.value = savedValue;
                            }
                        }
                    });

                    if (validateInitialFields()) {
                        additionalFields.style.display = 'block'; // Show additional fields if valid
                    }
                }

                // Validate required fields
                function validateInitialFields() {
                    for (let i = 0; i < inputs.length; i++) {
                        const input = inputs[i];
                        if (input.closest('#additionalFields')) continue;
                        if (!input.value) {
                            return false;
                        }
                    }
                    return true;
                }

                // Save data on input changes
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        saveFormData();
                        if (validateInitialFields()) {
                            additionalFields.style.display = 'block';
                        } else {
                            additionalFields.style.display = 'none';
                        }
                    });
                });

                // Clear session data when the form is submitted
                form.addEventListener('submit', function() {
                    sessionStorage.clear();
                });

                // Load form data when the page loads
                loadFormData();
            });
        </script>
    @endpush
@endsection
