<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Rental;
use App\Models\Transaction;

class RentalController extends Controller
{
    /**
     * Show the rental form for a specific car.
     */
    public function order($carId)
{
    // Pastikan mobil tersedia
    $car = Car::findOrFail($carId);

    return view('rental.order', compact('car')); // Kirim data mobil ke view
}

public function processRental(Request $request)
{
    $validated = $request->validate([
        'car_id' => 'required|exists:cars,id',
        'name' => 'required|string|max:255',
        'phone' => 'required|numeric|digits_between:10,15',
        'email' => 'required|email',
        'address' => 'required|string',
        'id_card' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
        'duration' => 'required|integer',
        'return_date' => 'required|date',
        'payment_method' => 'required|string',
        'total_payment' => 'required|numeric',
    ]);

    // Upload file KTP/SIM
    $idCardPath = $request->file('id_card')->store('uploads/id_cards', 'public');

    // Simpan data rental
    $rental = Rental::create([
        'user_id' => auth()->id(),
        'car_id' => $request->car_id,
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
        'id_card' => $idCardPath,
        'duration' => $request->duration,
        'return_date' => $request->return_date,
        'payment_method' => $request->payment_method,
        'total_payment' => $request->total_payment,
        'status' => 'Pending',
    ]);

    // Update status mobil menjadi "Dirental"
    $car = Car::findOrFail($request->car_id);
    $car->status = 'Dirental';
    $car->save();

    // Buat transaksi
    Transaction::create([
        'user_id' => auth()->id(),
        'rental_id' => $rental->id,
        'payment_method' => $request->payment_method,
        'total_payment' => $request->total_payment,
        'status' => 'Pending',
    ]);

    return redirect()->route('user')->with('success', 'Rental berhasil dibuat!');
}

}
