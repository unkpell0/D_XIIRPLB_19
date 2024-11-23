<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Transaction;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function showPaymentForm($rentalId)
    {
        try {
            $rental = Rental::with(['user', 'car'])
                           ->where('status', Transaction::VALID_STATUSES[0]) // 'Pending'
                           ->findOrFail($rentalId);

            return view('rental.payment', compact('rental'));
        } catch (\Exception $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Rental tidak ditemukan atau sudah tidak valid.');
        }
    }

    public function processPayment(Request $request, $rentalId)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer',
            'total_payment' => 'required|numeric|min:0',
        ]);

        try {
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
                throw new \Exception('Gagal menyimpan transaksi');
            }

            // Update rental status
            $rental->status = Transaction::VALID_STATUSES[1]; // 'Dirental'
            if (!$rental->save()) {
                // Rollback: delete transaction jika gagal update rental
                $transaction->delete();
                throw new \Exception('Gagal mengupdate status rental');
            }

            // Update car status
            $car = Car::findOrFail($rental->car_id);
            $car->status = Car::STATUS_DISEWA;
            if (!$car->save()) {
                // Rollback: delete transaction dan kembalikan status rental
                $transaction->delete();
                $rental->status = Transaction::VALID_STATUSES[0];
                $rental->save();
                throw new \Exception('Gagal mengupdate status mobil');
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

            return redirect()
                ->route('rental.success', ['rentalId' => $rental->id])
                ->with('success', 'Pembayaran berhasil. Rental dikonfirmasi!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    private function generateReceiptPDF($transactionId)
    {
        $transaction = Transaction::with(['rental.car'])
                                ->findOrFail($transactionId);

        return Pdf::loadView('rental.receipt-pdf', compact('transaction'));
    }

    public function rentalSuccess($rentalId)
    {
        try {
            $rental = Rental::with(['car'])
                           ->where('status', Transaction::VALID_STATUSES[1]) // 'Dirental'
                           ->findOrFail($rentalId);

            return view('rental.success', compact('rental'));
        } catch (\Exception $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Rental tidak ditemukan.');
        }
    }
}
