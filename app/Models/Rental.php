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
        'user_id',
        'name',
        'phone',
        'email',
        'address',
        'id_card',
        'duration',
        'start_date',
        'return_date',
        'return_condition',
        'return_kilometer',
        'payment_method',
        'total_payment',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'start_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($rental) {
            if (is_null($rental->start_date)) {
                $rental->start_date = now(); // Tetapkan nilai default
            }
        });
    }


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

    public function returnTransaction()
    {
        return $this->hasOne(Transaction::class, 'rental_id', 'id');
    }

}
