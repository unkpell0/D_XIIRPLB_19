<?php

namespace App\Models;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function car()
    {
        return $this->belongsToMany(Car::class);
    }

    protected $primaryKey = 'id';
}
