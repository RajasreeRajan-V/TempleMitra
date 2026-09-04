<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplesRegistration extends Model
{
    use HasFactory;

    protected $table = 'temples_registration';

    protected $fillable = [
        'temple_name',
        'address',
        'district',
        'location',
        'contact_number',
        'email',
        'description',
        'logo',
        'registration_number',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}