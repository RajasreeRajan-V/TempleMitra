<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vazhipad extends Model
{
    use HasFactory;

    protected $fillable = [
        'temple_id',
        'name',
        'description',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function temple()
    {
        return $this->belongsTo(
            TemplesRegistration::class,
            'temple_id'
        );
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }
}