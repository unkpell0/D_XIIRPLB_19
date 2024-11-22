<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    /**
     * Define status constants
     */
    const STATUS_TERSEDIA = 'tersedia';
    const STATUS_DISEWA = 'disewa';
    const STATUS_MAINTENANCE = 'maintenance';

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
        'status',
        'rental_price',
    ];

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
    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_TERSEDIA;
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
}
