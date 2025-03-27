<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function history()
    {
        // Ambil semua user dengan hubungan rental untuk transaksi
        $users = User::with(['rental.car'])->latest()->get();

        return view('admin.history', compact('users'));
    }
}
