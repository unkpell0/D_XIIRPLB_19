<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Car;
use App\Models\User;
use App\Models\Rental;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function showPaymentForm($rentalId)
    {
        // try {
        $rental = Rental::with(['user', 'car'])
            // ->where('status', Transaction::VALID_STATUSES[0]) // 'Pending'
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
            'bank_name' => 'required_if:payment_method,bank_transfer',
            'card_number' => 'required_if:payment_method,bank_transfer|regex:/^\d{4}-\d{4}-\d{4}-\d{4}$/',
            'expiry_date' => 'required_if:payment_method,bank_transfer|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required_if:payment_method,bank_transfer|regex:/^\d{3}$/',
            'card_holder' => 'required_if:payment_method,bank_transfer',
        ]);

        // $rental = Rental::where('status', Transaction::VALID_STATUSES[0]) // 'Pending'
        //     ->findOrFail($rentalId);

        $rental = Rental::findOrFail($rentalId);

        // Batasi maksimal 3 mobil per user
        // $activeRentals = Rental::where('user_id', Auth::id())
        //     ->where('status', Transaction::VALID_STATUSES[0]) // 'Dirental'
        //     ->count();

        // if ($activeRentals >= 2) {
        //     return redirect()
        //         ->route('user')
        //         ->with('error', 'Anda sudah mencapai batas maksimum menyewa 3 mobil. Harap kembalikan mobil terlebih dahulu.');
        // }

        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->rental_id = $rental->id;
        $transaction->payment_method = $request->payment_method;
        $transaction->total_payment = $request->total_payment;
        $transaction->bank_name = $request->bank_name ?? null;
        $transaction->card_number = $request->card_number ?? null;
        $transaction->card_holder = $request->card_holder ?? null;

        // $transaction->status = Transaction::VALID_STATUSES[0]; // 'Pending'

        if (!$transaction->save()) {
            throw new Exception('Gagal menyimpan transaksi');
        }

        $car = Car::findOrFail($rental->car_id);
        $car->decreaseCount();

        // session()->flash('payment_confirmed', true);

        return redirect()
            ->route('rental.success', ['rentalId' => $rental->id])
            ->with('success', 'Pembayaran berhasil. Rental dikonfirmasi!');
    }

    private function generateReceiptPDF($transactionId)
    {
        $transaction = Transaction::with(['rental.car', 'rental.user'])
            ->findOrFail($transactionId);

        $rental = $transaction->rental;

        return Pdf::loadView('rental.receipt-pdf', compact('transaction', 'rental'));
    }

    public function rentalSuccess($rentalId)
    {
        // Tidak perlu validasi status lagi
        $rental = Rental::with(['car'])
            ->where('id', $rentalId)
            ->firstOrFail();

        return view('rental.success', compact('rental'));
    }


    public function printReceipt($rentalId)
    {
        $transaction = Transaction::with(['rental.car'])
            ->whereHas('rental', function ($query) use ($rentalId) {
                $query->where('id', $rentalId);
            })
            ->firstOrFail();

        $pdf = $this->generateReceiptPDF($transaction->id);
        $filename = 'receipt_' . $transaction->id . '.pdf';
        $path = storage_path('app/temp/' . $filename);
        $pdf->save($path);

        return response()
            ->download($path, $filename)
            ->deleteFileAfterSend(true);
    }

    public function returnForm($carId)
    {
        $car = Car::findOrFail($carId);

        // Pastikan mobil dalam status "disewa"
        // if ($car->status !== Car::STATUS_DISEWA) {
        //     return redirect()->route('user')->with('error', 'Mobil tidak sedang disewa.');
        // }

        return view('rental.return', compact('car'));
    }

    public function processReturn(Request $request, $carId)
    {
        $request->validate([
            'condition' => 'required|string',
            'kilometer' => 'required|numeric|min:0',
        ]);

        $car = Car::findOrFail($carId);
        $rental = Rental::where('car_id', $car->id)->firstOrFail();

        // Perbarui status rental menjadi 'maintenance'
        // $rental->status = Transaction::VALID_STATUSES[0]; // 'maintenance'
        $rental->return_condition = $request->condition;
        $rental->return_kilometer = $request->kilometer;
        $rental->return_date = now();
        $rental->save();

        // Tambahkan kembali jumlah mobil
        $car->increaseCount();

        return redirect()->route('user')->with('success', 'Mobil berhasil dikembalikan.');
    }

    // public function processRental(Request $request, $carId)
    // {
    //     // Check rental limit
    //     $activeRentals = Car::getUserActiveRentals();
    //     if ($activeRentals >= 3) {
    //         return redirect()
    //             ->back()
    //             ->with('error', 'Anda telah mencapai batas maksimal penyewaan (3 mobil). Harap kembalikan mobil terlebih dahulu.');
    //     }

    //     // Continue with rental process
    //     $car = Car::findOrFail($carId);

    //     if ($car->count <= 0) {
    //         return redirect()
    //             ->back()
    //             ->with('error', 'Maaf, mobil ini sedang tidak tersedia untuk disewa.');
    //     }

    //     // Create rental record
    //     $rental = new Rental();
    //     $rental->user_id = Auth::id();
    //     $rental->car_id = $car->id;
    //     $rental->start_date = now();
    //     $rental->status = 'Pending';

    //     if (!$rental->save()) {
    //         return redirect()
    //             ->back()
    //             ->with('error', 'Gagal menyimpan data rental');
    //     }

    //     // Decrease car count
    //     $car->count -= 1;
    //     $car->save();

    //     return redirect()
    //         ->route('rental.payment', ['rentalId' => $rental->id])
    //         ->with('success', 'Silakan lanjutkan ke pembayaran');
    // }

    // public function showUserRentals()
    // {
    //     $user = Auth::user();
    //     $activeRentals = Rental::with(['car'])
    //         ->where('user_id', $user->id)
    //         ->where('status', Transaction::VALID_STATUSES[1]) // 'Dirental'
    //         ->get();

    //     return view('user.user', [
    //         'activeRentals' => $activeRentals,
    //         'activeRentalsCount' => $activeRentals->count(),
    //         'remainingRentals' => $user->getRemainingRentalsAllowed()
    //     ]);

    // }
}
