<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class TransactionController extends Controller
{
    /**
     * Show payment form for a specific rental.
     *
     * @param int $rentalId
     * @return \Illuminate\View\View
     */
    public function showPaymentForm($rentalId)
    {
        // Fetch rental details
        $rental = Rental::with('user', 'car')->findOrFail($rentalId);

        // Return payment view
        return view('rental.payment', compact('rental'));
    }

    /**
     * Process the payment and update rental status.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $rentalId
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function processPayment(Request $request, $rentalId)
    {
        // Validate input
        $request->validate([
            'payment_method' => 'required|string',
            'total_payment' => 'required|numeric',
        ]);

        // Find rental
        $rental = Rental::findOrFail($rentalId);

        // Save transaction
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'rental_id' => $rental->id,
            'payment_method' => $request->payment_method,
            'total_payment' => $request->total_payment,
            'status' => 'Dirental',
        ]);

        // Update rental and car status
        $rental->update(['status' => 'Dirental']);
        $rental->car->update(['is_available' => false]); // Pastikan ada field `is_available` di tabel `cars`.

        // Generate and return receipt if requested
        if ($request->has('print_receipt')) {
            $pdf = $this->generateReceiptPDF($transaction->id);

            // Simpan PDF sebagai file sementara untuk diunduh
            $filename = 'receipt_' . $transaction->id . '.pdf';
            $path = storage_path('app/temp/' . $filename);
            $pdf->save($path);

            // Kirim file PDF sebagai unduhan
            return response()->download($path, $filename)->deleteFileAfterSend(true);
        }

        // Redirect to home with success message
        return redirect()->route('user')->with('success', 'Payment successful. Rental confirmed!');
    }



    /**
     * Generate the payment receipt as a PDF.
     *
     * @param int $transactionId
     * @return \Barryvdh\DomPDF\PDF
     */
    private function generateReceiptPDF($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $rental = Rental::with(['user', 'car'])->findOrFail($transaction->rental_id);

        return Pdf::loadView('rental.receipt-pdf', [
            'rental' => $rental,
            'transaction' => $transaction
        ]);
    }

    /**
     * Show the rental success page.
     *
     * @param int $rentalId
     * @return \Illuminate\View\View
     */
    public function rentalSuccess($rentalId)
    {
        $rental = Rental::findOrFail($rentalId);

        return view('rental.success', compact('rental'));
    }
}
