<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .content {
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>STRUK PEMBAYARAN RENTAL MOBIL</h2>
        {{-- <p>{{ date('d/m/Y H:i:s') }}</p> --}}
    </div>

    <div class="content">
        <table class="table">
            <tr>
                <td><strong>Nama Penyewa:</strong></td>
                <td>{{ optional($rental->user)->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Mobil:</strong></td>
                <td>{{ optional($rental->car)->nama ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Nomor Plat:</strong></td>
                <td>{{ optional($rental->car)->plat_nomor ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Durasi Sewa:</strong></td>
                <td>{{ $rental->duration ?? 0 }} Hari</td>
            </tr>
            <tr>
                <td><strong>Metode Pembayaran:</strong></td>
                <td>{{ $transaction->payment_method === 'bank_transfer' ? 'Transfer Bank' : 'Tunai' }}</td>
            </tr>
            @if ($transaction->payment_method === 'bank_transfer')
                <tr>
                    <td><strong>Nama Bank:</strong></td>
                    <td>{{ $transaction->bank_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Nomor Kartu:</strong></td>
                    <td>{{ $transaction->card_number ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Pemegang Kartu:</strong></td>
                    <td>{{ $transaction->card_holder ?? 'N/A' }}</td>
                </tr>
            @elseif ($transaction->payment_method === '')
            @endif
            <tr>
                <td><strong>Tanggal Rental:</strong></td>
                <td>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y H:i') ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Pengembalian:</strong></td>
                <td>{{ \Carbon\Carbon::parse($rental->return_date)->format('d/m/Y H:i') ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Total Pembayaran:</strong></td>
                <td>Rp{{ number_format($transaction->total_payment ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>


    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami!</p>
    </div>
</body>

</html>
