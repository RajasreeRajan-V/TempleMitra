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
     * Display receipts belonging only to the logged-in temple.
     */
    public function index(Request $request)
    {
        $templeId = session('temple_id');

        $receiptss = Receipt::with([
            'items.vazhipad'
        ])
        ->where('temple_id', $templeId)
        ->latest('receipts_date')
        ->paginate(15);

        return view(
            'temple.receipts.index',
            compact('receiptss')
        );
    }

    /**
     * Show create receipt form.
     *
     * Only Vazhipads belonging to the logged-in temple
     * will be displayed.
     */
    public function create()
    {
        $templeId = session('temple_id');

        $vazhipads = Vazhipad::where('temple_id', $templeId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'temple.receipts.create',
            compact('vazhipads')
        );
    }

    /**
     * Store receipt and receipt items.
     */
    public function store(Request $request)
    {
        $templeId = session('temple_id');

        // Make sure a temple is actually logged in.
        if (!$templeId) {
            return redirect()
                ->route('temple.login')
                ->with('error', 'Please login to your temple account.');
        }

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
                'integer',
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

        /*
         * IMPORTANT SECURITY CHECK
         *
         * Get only Vazhipads belonging to the logged-in temple.
         */
        $vazhipads = Vazhipad::whereIn(
            'id',
            $validated['vazhipad_id']
        )
        ->where('temple_id', $templeId)
        ->where('status', 'active')
        ->get();

        /*
         * If the number of requested Vazhipads and the number
         * belonging to this temple are different, someone tried
         * to use another temple's Vazhipad.
         */
        if ($vazhipads->count() !== count($validated['vazhipad_id'])) {
            abort(403, 'You cannot use a Vazhipad belonging to another temple.');
        }

        $receipt = DB::transaction(function () use (
            $validated,
            $templeId
        ) {

            /*
             * Receipt belongs directly to the logged-in temple.
             */
            $receipt = Receipt::create([
                'temple_id' => $templeId,

                'devotee_name' => $validated['devotee_name'],

                'nakshatram' => $validated['nakshatram'],

                'receipts_date' => $validated['receipts_date'],

                'total_amount' => 0,

                'status' => 'pending',
            ]);

            foreach (
                $validated['vazhipad_id']
                as $index => $vazhipadId
            ) {

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
     * Show a receipt only if it belongs to the logged-in temple.
     */
    public function show(Receipt $receipt)
    {
        $templeId = session('temple_id');

        if ($receipt->temple_id != $templeId) {
            abort(403, 'Unauthorized access.');
        }

        $receipt->load('items.vazhipad');

        return view(
            'temple.receipts.show',
            compact('receipt')
        );
    }
}