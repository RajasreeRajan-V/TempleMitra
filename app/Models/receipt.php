<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'devotee_id',
        'receipt_date',
        'vazhipad_id',
        'devotee_name',
        'nakshatram',
        'receipts_date',
        'total_amount',
        'payment_status',
        'payment_method',
        'transaction_id', // ADD THIS
        'paid_amount',
        'paid_at',
        'amount',
        'status',
    ];

    protected $casts = [
        'receipt_date'  => 'date',
        'receipts_date' => 'date',
        'total_amount'  => 'decimal:2',
        'paid_amount'   => 'decimal:2',
        'amount'        => 'decimal:2',
        'paid_at'       => 'datetime',
    ];

    public function devotee()
    {
        return $this->belongsTo(Devotee::class);
    }

    public function vazhipad()
    {
        return $this->belongsTo(Vazhipad::class);
    }

    public function items()
    {
        return $this->hasMany(ReceiptItem::class);
    }

    public function scopeBetweenDates($query, $from, $to)
    {
        return $query->whereBetween('receipts_date', [$from, $to]);
    }

    public function recalculateTotal(): void
    {
        $this->total_amount = $this->items()->sum('amount');
        $this->save();
    }
}