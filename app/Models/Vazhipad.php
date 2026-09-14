<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vazhipad extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'status'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

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