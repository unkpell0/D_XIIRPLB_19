<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //untuk mengecek apakah sudah login atau belum
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::latest()->paginate(5); //menampilkan 5 data
        return view('car.index', compact('cars')); //menampilkan view index.blade.php yang ada di folder
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('car.create'); //menuju view create yang ada di folder create
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [ //untuk memvalidasi input user dimana ada required yang bersifat wajib
            'nama' => 'required',
            'jenis' => 'required',
            'merek' => 'required',
            'tipe' => 'required',
            'plat_nomor' => 'required|max:10|unique:cars',
            'tahun_produksi' => 'required|digits: 4|integer|min:2000|max:' . date('Y'),
            'image' => 'required|image|mimes:jpg,png,jpeg',
            'status' => 'required',
        ]);

        //upload image
        $image = $request->file('image'); //untuk menyimpan gambar
        $image->storeAs('public/cars', $image->hashName()); //untuk mengubah nama file gambar menjadi hash

        $car = Car::create([ // untuk menambahkan ke database phpmyadmin
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'merek' => $request->merek,
            'tipe' => $request->tipe,
            'plat_nomor' => $request->plat_nomor,
            'tahun_produksi' => $request->tahun_produksi,
            'image' => $image->hashName(),
            'status' => $request->status,
        ]);
        if ($car) {
            //redirect ke index dengan pesan sukses
            return redirect()->route('car.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect ke index dengan pesan error
            return redirect()->route('car.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('car.edit', compact('car')); //menuju ke view edit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $this->validate($request, [ //memvalidasi inputan user saat edit data
            'nama' => 'required',
            'jenis' => 'required',
            'merek' => 'required',
            'tipe' => 'required',
            'plat_nomor' => 'required|max:10|unique:cars,plat_nomor,' . $car->id,
            'tahun_produksi' => 'required|digits: 4|integer|min:2000|max:' . date('Y'),
            'status' => 'required',]);
        // ], [
        //     'status.required' => 'Status wajib diisi.',
        //     'status.in' => 'Status harus berupa Tersedia atau Tidak Tersedia atau Dirental.',
        // ]);

        //get data Blog by ID
        $car = Car::findOrFail($car->id);

        if ($request->hasFile('image')) {

            if ($car->image && Storage::exists('public/cars/' . $car->image)) {
                Storage::delete('public/cars/' . $car->image);
            }

            $image = $request->file('image');
            $image->storeAs('public/cars', $image->hashName());

            $car->update([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'merek' => $request->merek,
                'tipe' => $request->tipe,
                'plat_nomor' => $request->plat_nomor,
                'tahun_produksi' => $request->tahun_produksi,
                'status' => $request->status,
                'image' => $image->hashName(),
            ]);

        } else {

            $car->update([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'merek' => $request->merek,
                'tipe' => $request->tipe,
                'plat_nomor' => $request->plat_nomor,
                'tahun_produksi' => $request->tahun_produksi,
                'status' => $request->status,
            ]);

        }

        if ($car) {
            //redirect dengan pesan sukses
            return redirect()->route('car.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('car.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::findOrFail($id);
        // Hapus gambar jika ada
        if ($car->image && Storage::exists('public/cars/' . $car->image)) {
            Storage::delete('public/cars/' . $car->image);
        }

        $car->delete();

        if ($car) {
            //redirect dengan pesan sukses
            return redirect()->route('car.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('car.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}
