<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'devotee_name',
        'nakshatram',
        'receipts_date',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'receipts_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(
            ReceiptItem::class,
            'receipt_id'
        );
    }

    public function recalculateTotal()
    {
        $total = $this->items()
            ->get()
            ->sum(function ($item) {
                return (float) $item->quantity *
                       (float) $item->amount;
            });

        $this->total_amount = $total;

        $this->save();

        return $this;
    }
}