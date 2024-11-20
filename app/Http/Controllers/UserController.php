<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function dashboard(){
        return view('user.dashboard');
    }
    public function Index()
    {
        $cars = Car::all();
        return view('user.user', compact('cars'));
    }

    public function rental($id)
    {
        // Ambil mobil berdasarkan ID
        $car = Car::findOrFail($id);

        // Logika pemesanan, misalnya:
        // - Periksa ketersediaan mobil
        // - Simpan data pemesanan di database
        // - Kirim konfirmasi ke user
        // - Ubah status mobil menjadi "dirental"
        if ($car->status == 'Tersedia') {
            // Ubah status mobil
            $car->status = 'Dirental';
            $car->save();

            // Simpan pemesanan ke tabel rental (opsional, buat model Order)
            Rental::create([
                'user_id' => auth() -> id(),
                'car_id' => $car->id,
                'status' => 'Dirental',
            ]);
    
            return redirect()->back()->with('Success', 'Mobil berhasil dirental');
        } else{
            return redirect()->back()->with('error', 'Mobil tidak tersedia.');
        }
    }
}
