<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';
    
    // UUID primary key handling
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Standard timestamps
    public $timestamps = true;

    protected $fillable = [
        'id',
        'title',
        'category',
        'amount',
        'expense_date',
        'notes',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Boot function to automatically generate UUID for primary key
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
