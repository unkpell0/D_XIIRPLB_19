<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rental_id',
        'payment_method',
        'total_payment',
        'status'
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rental associated with the transaction.
     */
    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function transaction()
{
    return $this->hasOne(Transaction::class);
}
}
