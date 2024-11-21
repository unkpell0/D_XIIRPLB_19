<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function showPaymentForm($rentalId)
    {
        $rental = Rental::findOrFail($rentalId);
        return view('rental.payment', compact('rental'));
    }


    public function processPayment(Request $request, $rentalId)
    {
        // Fetch the rental details
        $rental = Rental::findOrFail($rentalId);

        // Validate the payment data
        $request->validate([
            'payment_method' => 'required|string',
            'total_payment' => 'required|numeric',
        ]);

        // Create a new transaction record
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'rental_id' => $rental->id,
            'payment_method' => $request->payment_method,
            'total_payment' => $request->total_payment,
            'status' => 'Dirental', // or 'Pending' based on your flow
        ]);

        // Update rental status to 'Dirental'
        $rental->status = 'Dirental';
        $rental->save();

        // Redirect or show success message
        return redirect()->route('user.rental.success', ['rental' => $rentalId])
            ->with('success', 'Payment completed and rental confirmed!');
    }

}

