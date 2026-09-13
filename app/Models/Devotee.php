<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devotee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'address', 'star'];

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}