<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;
    /**
     * Define status constants
     */


    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, mixed>
     */
    protected $fillable = [
        'nama',
        'jenis',
        'merek',
        'tipe',
        'plat_nomor',
        'tahun_produksi',
        'image',
        'rental_price',
        'note',
        'count',
    ];

    public function decreaseCount()
    {
        if ($this->count > 0) {
            $this->count -= 1;
            if ($this->count === 0) {
                $this->status = self::STATUS_MAINTENANCE;
            }
            $this->save();
            return true;
        }
        return true;
    }

    public function increaseCount()
    {
        $this->count += 1;
        if ($this->status === self::STATUS_MAINTENANCE) {
            $this->status = self::STATUS_TERSEDIA;
        }
        $this->save();
        return true;
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_produksi' => 'integer',
        'rental_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Get all available car statuses.
     *
     * @return array<string>
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_TERSEDIA,
            self::STATUS_DISEWA,
            self::STATUS_MAINTENANCE,
        ];
    }

    /**
     * Get the rentals for the car.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Check if the car is available for rent.
     *
     * @return bool
     */
    // Hapus fungsi terkait `status`
    public function isAvailable(): bool
    {
        return $this->count > 0;
    }

    /**
     * Check if the car is currently rented.
     *
     * @return bool
     */
    public function isRented(): bool
    {
        return $this->status === self::STATUS_DISEWA;
    }

    /**
     * Get the car's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->merek} {$this->tipe}";
    }

    /**
     * Get formatted rental price.
     *
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->rental_price, 0, ',', '.');
    }

    /**
     * Format tahun_produksi before saving.
     *
     * @param mixed $value
     * @return void
     */
    public function setTahunProduksiAttribute($value): void
    {
        $this->attributes['tahun_produksi'] = (int) $value;
    }

    /**
     * Scope a query to only include available cars.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_TERSEDIA);
    }

    /**
     * Scope a query to only include rented cars.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRented($query)
    {
        return $query->where('status', self::STATUS_DISEWA);
    }

    public function canBeRented(): bool
    {
        return $this->count > 0;
    }

    /**
     * Check if car is rented by current user
     */
    public function isRentedByUser(): bool
    {
        return Rental::where('user_id', Auth::id())
            ->where('car_id', $this->id)
            ->where('status', Transaction::VALID_STATUSES[1]) // 'disewa'
            ->exists();
    }

    /**
     * Get user's active rental count
     */
    public static function getUserActiveRentals()
    {
        return Rental::where('user_id', Auth::id())
            ->where('status', 'Dirental')
            ->count();
    }
}
