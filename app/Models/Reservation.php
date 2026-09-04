<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'user_id',
        'room_id',
        'start_date',
        'end_date',
        'duration_months',
        'status',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getTotalPriceAttribute($value)
    {
        if ($value) {
            return (float)$value;
        }
        $pricePerMonth = $this->room ? (float)$this->room->price_per_month : 1500000;
        return $pricePerMonth * ($this->duration_months ?: 1);
    }

    public function getEndDateAttribute($value)
    {
        if ($value) {
            return $value;
        }
        if (!$this->start_date) return null;
        return \Carbon\Carbon::parse($this->start_date)->addMonths($this->duration_months ?: 1)->toDateString();
    }
}
