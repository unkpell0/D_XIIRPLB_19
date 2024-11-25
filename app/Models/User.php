<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Rental;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const MAX_RENTALS = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $primaryKey = 'id';

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value) => ["user", "admin"][$value],
        );
    }

    public function rental()
    {
        return $this->hasMany(Rental::class);
    }

    public function isAdmin()
    {
        return $this->type === 'admin';
    }

    public function isUser()
    {
        return $this->type === 'user';
    }

    // Modifikasi method yang ada
    public function getRemainingRentalsAllowed(): int
    {
        return self::MAX_RENTALS - $this->getActiveRentalsCount();
    }

    public function canRentMoreCars(): bool
{
    return $this->getActiveRentalsCount() < self::MAX_RENTALS;
}

    /**
     * Get count of currently active rentals for the user
     *
     * @return int
     */
    public function getActiveRentalsCount(): int
{
    return $this->rental()->count(); // Tidak lagi memeriksa status
}

    // /**
    //  * Check if user can rent more cars
    //  *
    //  * @return bool
    //  */
    // public function canRentMoreCars(): bool
    // {
    //     return $this->getActiveRentalsCount() < 3;
    // }

    // /**
    //  * Get remaining rentals allowed
    //  *
    //  * @return int
    //  */
    // public function getRemainingRentalsAllowed(): int
    // {
    //     return 3 - $this->getActiveRentalsCount();
    // }
}
