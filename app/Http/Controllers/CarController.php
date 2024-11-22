<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CarRequest;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of cars.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cars = Car::latest()->paginate(10);
        return view('car.index', compact('cars'));
    }

    /**
     * Show the form for creating a new car.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $statuses = Car::getStatuses();
        return view('car.create', compact('statuses'));
    }

    /**
     * Store a newly created car in storage.
     *
     * @param \App\Http\Requests\CarRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CarRequest $request)
    {
        $image = $request->file('image');
        $imagePath = $image->storeAs('public/cars', $image->hashName());

        $car = Car::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'merek' => $request->merek,
            'tipe' => $request->tipe,
            'plat_nomor' => $request->plat_nomor,
            'tahun_produksi' => $request->tahun_produksi,
            'image' => $image->hashName(),
            'status' => $request->status,
            'rental_price' => $request->rental_price,
        ]);

        return redirect()
            ->route('car.index')
            ->with('success', 'Data Berhasil Disimpan!');
    }

    /**
     * Edit the specified car.
     *
     * @param \App\Models\Car $car
     * @return \Illuminate\View\View
     */
    public function edit(Car $car)
    {
        $statuses = Car::getStatuses();
        return view('car.edit', compact('car', 'statuses'));
    }

    /**
     * Update the specified car in storage.
     *
     * @param \App\Http\Requests\CarRequest $request
     * @param \App\Models\Car $car
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CarRequest $request, Car $car)
    {
        $car->update($request->validated());

        if ($request->hasFile('image')) {
            // Delete old image
            if ($car->image) {
                Storage::delete('public/cars/' . $car->image);
            }

            // Store new image
            $image = $request->file('image');
            $car->image = $image->hashName();
            $image->storeAs('public/cars', $image->hashName());
            $car->save();
        }

        return redirect()
            ->route('car.index')
            ->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified car from storage.
     *
     * @param \App\Models\Car $car
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Car $car)
    {
        if ($car->image) {
            Storage::delete('public/cars/' . $car->image);
        }

        $car->delete();

        return redirect()
            ->route('car.index')
            ->with('success', 'Data Berhasil Dihapus!');
    }
}
