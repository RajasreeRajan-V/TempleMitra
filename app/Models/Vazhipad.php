<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vazhipad extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'amount', 'is_active'];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}