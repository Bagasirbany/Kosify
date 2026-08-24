<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public const UPDATED_AT = null;

    protected $fillable = [
        'reservation_id',
        'user_id',
        'amount',
        'payment_method',
        'proof_of_payment_url',
        'due_date',
        'status',
        'verified_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'verified_at' => 'datetime',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'user_id');
    }
}
