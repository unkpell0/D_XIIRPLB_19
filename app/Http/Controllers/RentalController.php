<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Rental;

class RentalController extends Controller
{
    /**
     * Show the order form for a car.
     *
     * @param int $carId
     * @return \Illuminate\View\View
     */
    public function order($carId)
    {
        $car = Car::where('id', $carId)->where('status', Car::STATUS_TERSEDIA)->firstOrFail();

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
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'id_card' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'duration' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);

        // Fetch the selected car
        $car = Car::findOrFail($request->car_id);

        // Calculate total payment
        $totalPayment = $this->calculateTotalPayment($request->duration, $car);

        // Calculate the return date
        $returnDate = now()->addDays($request->duration);

        // Create new rental
        $rental = new Rental();
        $rental->user_id = auth()->id();
        $rental->car_id = $car->id;
        $rental->name = $request->name;
        $rental->phone = $request->phone;
        $rental->email = $request->email;
        $rental->address = $request->address;
        $rental->duration = $request->duration;
        $rental->return_date = $returnDate;
        $rental->payment_method = $request->payment_method;
        $rental->total_payment = $totalPayment;

        // Upload ID card
        if ($request->hasFile('id_card')) {
            $rental->id_card = $request->file('id_card')->store('id_cards');
        }

        // Save rental data
        $rental->save();

        // Store rental data in session for payment
        session([
            'rental_id' => $rental->id,
            'total_payment' => $rental->total_payment,
            'duration' => $rental->duration,
        ]);

        // Redirect to payment page
        return redirect()->route('rental.payment.form', ['rentalId' => $rental->id]);
    }

    /**
     * Calculate the total paysment based on duration and car rental price.
     *
     * @param int $duration
     * @param \App\Models\Car $car
     * @return float
     */
    private function calculateTotalPayment($duration, $car)
    {
        return $car->rental_price * $duration;
    }
}
