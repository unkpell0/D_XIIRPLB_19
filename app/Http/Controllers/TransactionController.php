<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Car;
use App\Models\Rental;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function showPaymentForm($rentalId)
    {
        // try {
        $rental = Rental::with(['user', 'car'])
            ->where('status', Transaction::VALID_STATUSES[0]) // 'Pending'
            ->findOrFail($rentalId);

        return view('rental.payment', compact('rental'));
        // } catch (\Exception $e) {
        //     return redirect()
        //         ->route('home')
        //         ->with('error', 'Rental tidak ditemukan atau sudah tidak valid.');
        // }
    }

    public function processPayment(Request $request, $rentalId)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer',
            'total_payment' => 'required|numeric|min:0',
        ]);

        $rental = Rental::where('status', Transaction::VALID_STATUSES[0]) // 'Pending'
            ->findOrFail($rentalId);

        // Create transaction
        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->rental_id = $rental->id;
        $transaction->payment_method = $request->payment_method;
        $transaction->total_payment = $request->total_payment;
        $transaction->status = Transaction::VALID_STATUSES[1]; // 'Dirental'

        if (!$transaction->save()) {
            throw new Exception('Gagal menyimpan transaksi');
        }

        // Update rental status
        $rental->status = Transaction::VALID_STATUSES[1]; // 'Dirental'
        if (!$rental->save()) {
            // Rollback: delete transaction jika gagal update rental
            $transaction->delete();
            throw new Exception('Gagal mengupdate status rental');
        }

        // Update car status
        $car = Car::findOrFail($rental->car_id);
        $car->status = Car::STATUS_DISEWA;
        if (!$car->save()) {
            // Rollback: delete transaction dan kembalikan status rental
            $transaction->delete();
            $rental->status = Transaction::VALID_STATUSES[0];
            $rental->save();
            throw new Exception('Gagal mengupdate status mobil');
        }

        // Handle PDF generation if requested
        if ($request->has('print_receipt')) {
            $pdf = $this->generateReceiptPDF($transaction->id);
            $filename = 'receipt_' . $transaction->id . '.pdf';
            $path = storage_path('app/temp/' . $filename);
            $pdf->save($path);

            return response()
                ->download($path, $filename)
                ->deleteFileAfterSend(true);
        }

        // Redirect to success page if no PDF requested
        return redirect()
            ->route('rental.success', ['rentalId' => $rental->id])
            ->with('success', 'Pembayaran berhasil. Rental dikonfirmasi!');
    }



    private function generateReceiptPDF($transactionId)
    {
        $transaction = Transaction::with(['rental.car'])
            ->findOrFail($transactionId);

        // Ambil rental dari relasi transaction
        $rental = $transaction->rental;

        return Pdf::loadView('rental.receipt-pdf', compact('transaction', 'rental'));
    }


    public function rentalSuccess($rentalId)
    {
        // Temukan rental dengan status 'Dirental'
        $rental = Rental::with(['car'])
            ->where('id', $rentalId)
            ->where('status', Transaction::VALID_STATUSES[1]) // 'Dirental'
            ->firstOrFail();

        // Perbarui status rental jika belum diubah ke 'Disewa'
        if ($rental->status !== Transaction::VALID_STATUSES[1]) { // 'Disewa'
            $rental->status = Transaction::VALID_STATUSES[1]; // 'Disewa'
            $rental->save();

            // Perbarui status mobil menjadi 'Disewa'
            $car = $rental->car;
            $car->status = Car::STATUS_DISEWA; // Status 'Disewa'
            $car->save();
        }

        return view('rental.success', compact('rental'));
    }

}
