<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Car;
use App\Models\Rental;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    /**
     * Show the order form for a car.
     *
     * @param int $carId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function order($carId)
    {
        $car = Car::where('id', $carId)->where('count', '>', 0)->first();

        if (!$car) {
            return redirect()->route('user')->with('error', 'Mobil tidak tersedia atau sudah disewa.');
        }

        return view('rental.order', compact('car'));
    }

    /**
     * Store a new rental order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:1000',
            'id_card' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'duration' => 'required|integer|min:1|max:30',
            'return_date' => 'required|date|after:today',
            'payment_method' => 'required|in:cash,bank_transfer',
        ]);

        $car = Car::where('id', $request->car_id)->where('count', '>', 0)->first();

        if (!$car) {
            return redirect()
                ->route('home')
                ->with('error', 'Mobil tidak tersedia atau sudah disewa.');
        }

        // Hitung total pembayaran
        $totalPayment = $this->calculateTotalPayment($request->duration, $car);

        // Upload ID card
        $idCardPath = $request->file('id_card')->store('id_cards', 'public');

        // Buat order rental baru
        $rental = new Rental();
        $rental->car_id = $car->id;
        $rental->user_id = auth()->user()->id;
        $rental->name = $validated['name'];
        $rental->phone = $validated['phone'];
        $rental->email = $validated['email'];
        $rental->address = $validated['address'];
        $rental->id_card = $idCardPath;
        $rental->duration = $validated['duration'];
        $rental->return_date = $validated['return_date'];
        $rental->payment_method = $validated['payment_method'];
        $rental->total_payment = $totalPayment;
        $rental->save();

        // Update jumlah mobil yang tersedia
        $car->decreaseCount();

        return redirect()
            ->route('rental.payment.form', ['rentalId' => $rental->id])
            ->with('success', 'Order berhasil dibuat. Silahkan lakukan pembayaran.');
    }

    /**
     * Calculate the total payment based on duration and car rental price.
     *
     * @param int $duration
     * @param \App\Models\Car $car
     * @return float
     */
    private function calculateTotalPayment($duration, Car $car)
    {
        return $car->rental_price * $duration;
    }
}
