<?php

namespace App\Models;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'name',
        'phone',
        'email',
        'address',
        'id_card',
        'duration',
        'return_date',
        'payment_method',
        'total_payment',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    protected $primaryKey = 'id';

}
