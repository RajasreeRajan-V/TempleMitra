<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Note: this model is named "Collection", same as Illuminate\Support\Collection.
 * When importing it elsewhere, alias it, e.g.:
 *   use App\Models\Collection as TempleCollection;
 */
class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['source', 'amount', 'collection_date', 'collected_by', 'remarks'];

    protected $casts = [
        'amount' => 'decimal:2',
        'collection_date' => 'date',
    ];

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}