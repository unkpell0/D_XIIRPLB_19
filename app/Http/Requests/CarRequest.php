<?php

namespace App\Http\Requests;

use App\Models\Car;
use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:10',
            'tahun_produksi' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            // 'status' => 'required|in:' . implode(',', Car::getStatuses()),
            'rental_price' => 'required|numeric|min:0',
            'count' => 'required|numeric|min:1',
            'note'=> 'required|string|max:255',
        ];

        // Add unique validation for plat_nomor on create
        if ($this->isMethod('post')) {
            $rules['plat_nomor'] .= '|unique:cars';
            $rules['image'] = 'required|image|mimes:jpg,png,jpeg|max:2048';
        } else {
            // Modify unique validation for update
            $rules['plat_nomor'] .= '|unique:cars,plat_nomor,' . $this->car->id;
            $rules['image'] = 'nullable|image|mimes:jpg,png,jpeg|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama mobil harus diisi',
            'jenis.required' => 'Jenis mobil harus diisi',
            'merek.required' => 'Merek mobil harus diisi',
            'tipe.required' => 'Tipe mobil harus diisi',
            'plat_nomor.required' => 'Plat nomor harus diisi',
            'plat_nomor.unique' => 'Plat nomor sudah terdaftar',
            'tahun_produksi.required' => 'Tahun produksi harus diisi',
            'tahun_produksi.digits' => 'Tahun produksi harus 4 digit',
            'tahun_produksi.min' => 'Tahun produksi minimal 2000',
            'image.required' => 'Gambar mobil harus diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpg, png, atau jpeg',
            'rental_price.required' => 'Harga sewa harus diisi',
            'rental_price.numeric' => 'Harga sewa harus berupa angka',
            'rental_price.min' => 'Harga sewa minimal 0',
            'count.min' => 'Jumlah mobil minimal 0',
            'count.required' => 'Jumlah mobil harus diisi',
            'note.required' => 'Catatan harus diisi',
        ];
    }
}
