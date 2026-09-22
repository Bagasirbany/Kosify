<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'room_number',
        'room_type',
        'price_per_month',
        'status',
        'description',
        'photo',
        'gallery_photos',
    ];

    protected $casts = [
        'gallery_photos' => 'array',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get localized description based on current app locale.
     */
    public function getLocalizedDescriptionAttribute(): string
    {
        if (app()->getLocale() === 'en') {
            $enDescriptions = [
                '101' => '1st floor Deluxe Room with a warm minimalist ambiance, equipped with a spacious work desk, AC, plush queen-size bed, 2-door wardrobe, and private bathroom with shower.',
                '102' => '1st floor Standard Room ideal for students. Equipped with study desk, ergonomic chair, single springbed, large window with natural light, and high-speed WiFi.',
                '122' => 'Exclusive Standard Room in a quiet corner on the 1st floor. Equipped with premium single bed, work desk, private bathroom, and quick access to shared kitchen.',
                '201' => '2nd floor Executive Suite Room with spacious layout, classy modern wooden interior, smart TV, water heater, energy-saving inverter AC, mini fridge, and lounge area.',
                '202' => '2nd floor Standard Room with clean aesthetic white ambiance. Equipped with single bed, study desk, wardrobe, hanging bookshelf, and fresh air circulation.',
                '203' => '2nd floor Deluxe Room with Scandinavian wood wall accents, queen bed, cool AC, dressing/work desk, and modern private bathroom.',
                '301' => '3rd floor VIP Suite Room with city views, private balcony, king size bed, relaxation sofa, executive desk, water heater, and mini fridge.',
                '302' => '3rd floor Standard Room, quiet and comfortable for rest and study. Equipped with single springbed, study desk, storage rack, and 24/7 fast WiFi.',
                '303' => '3rd floor Deluxe Room with contemporary boutique hotel design. Equipped with premium queen bed, AC, water heater, and warm ambient lighting.',
            ];

            return $enDescriptions[$this->room_number] ?? ($this->description ?: 'Exclusive boarding room with complete amenities, comfortable bed, study desk, wardrobe, high-speed WiFi, and 24-hour self-access gate.');
        }

        return $this->description ?: 'Kos eksklusif dengan fasilitas lengkap kasur empuk, meja kerja, lemari, WiFi cepat, dan akses gerbang mandiri 24 jam.';
    }

    /**
     * Get localized room type.
     */
    public function getLocalizedRoomTypeAttribute(): string
    {
        $type = strtoupper($this->room_type ?: 'STANDARD');
        return $type;
    }

    /**
     * Get floor number based on room number.
     */
    public function getFloorNumberAttribute(): int
    {
        return (int) substr($this->room_number, 0, 1);
    }

    /**
     * Get zoning type: 'putra_pasutri' (Floor 1) or 'putri' (Floor 2 & 3).
     */
    public function getZoningTypeAttribute(): string
    {
        return $this->floor_number === 1 ? 'putra_pasutri' : 'putri';
    }

    /**
     * Get localized zoning badge for cards and tags.
     */
    public function getLocalizedZoningBadgeAttribute(): string
    {
        if (app()->getLocale() === 'en') {
            return $this->floor_number === 1 ? 'Floor 1 • Male / Married Couple' : 'Floor ' . $this->floor_number . ' • Female Only';
        }
        return $this->floor_number === 1 ? 'Lantai 1 • Putra / Pasutri' : 'Lantai ' . $this->floor_number . ' • Khusus Putri';
    }

    /**
     * Get localized description of zoning privileges.
     */
    public function getZoningDescriptionAttribute(): string
    {
        if (app()->getLocale() === 'en') {
            return $this->floor_number === 1 
                ? 'Designated for Male tenants or legally Married Couples. Quick access to motorcycle parking and main entrance gate.' 
                : 'Exclusively designated for Female tenants. Calm atmosphere, high privacy, and private stair access.';
        }
        return $this->floor_number === 1 
            ? 'Area lantai 1 dikhususkan untuk Putra atau Pasutri Sah. Akses langsung dekat area parkir dan pintu masuk utama.' 
            : 'Area lantai ' . $this->floor_number . ' dikhususkan Khusus Putri. Suasana tenang, aman, dan privasi penghuni wanita terjaga optimal.';
    }
}

