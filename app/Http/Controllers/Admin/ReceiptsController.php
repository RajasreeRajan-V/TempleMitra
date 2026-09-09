<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use App\Models\Vazhipad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptsController extends Controller
{
    /**
     * Display all receipts.
     */
    public function index()
    {
        $receiptss = Receipt::with('items.vazhipad')
            ->latest('receipts_date')
            ->paginate(15);

        return view('temple.receipts.index', compact('receiptss'));
    }

    /**
     * Show create receipt form.
     */
    public function create()
    {
        $vazhipads = Vazhipad::orderBy('name')->get();

        return view('temple.receipts.create', compact('vazhipads'));
    }

    /**
     * Store receipt and receipt items.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'devotee_name' => [
                'required',
                'string',
                'max:255',
            ],

            'nakshatram' => [
                'required',
                'string',
                'max:100',
            ],

            'receipts_date' => [
                'required',
                'date',
            ],

            'vazhipad_id' => [
                'required',
                'array',
                'min:1',
            ],

            'vazhipad_id.*' => [
                'required',
                'exists:vazhipads,id',
            ],

            'quantity' => [
                'required',
                'array',
            ],

            'quantity.*' => [
                'required',
                'integer',
                'min:1',
            ],

            'amount' => [
                'required',
                'array',
            ],

            'amount.*' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $receipt = DB::transaction(function () use ($validated) {

            $receipt = Receipt::create([
                'devotee_name' => $validated['devotee_name'],

                'nakshatram' => $validated['nakshatram'],

                // IMPORTANT
                'receipts_date' => $validated['receipts_date'],

                'total_amount' => 0,

                'status' => 'pending',
            ]);

            foreach ($validated['vazhipad_id'] as $index => $vazhipadId) {

                ReceiptItem::create([
                    'receipt_id' => $receipt->id,

                    'vazhipad_id' => $vazhipadId,

                    'quantity' => $validated['quantity'][$index],

                    'amount' => $validated['amount'][$index],
                ]);
            }

            $receipt->recalculateTotal();

            return $receipt;
        });

        return redirect()
            ->route(
                'temple.receipts.show',
                $receipt->id
            )
            ->with(
                'success',
                'Vazhipad receipt created successfully.'
            );
    }

    /**
     * Show single receipt.
     */
    public function show(Receipt $receipt)
    {
        $receipt->load('items.vazhipad');

        return view(
            'temple.receipts.show',
            compact('receipt')
        );
    }
}   