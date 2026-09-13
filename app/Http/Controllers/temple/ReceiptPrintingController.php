<?php

namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReceiptPrintingController extends Controller
{
    /**
     * Display all receipts for printing.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Receipt Query
        |--------------------------------------------------------------------------
        */

        $query = Receipt::with('items.vazhipad')
            ->latest('id');


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('devotee_name', 'like', "%{$search}%")
                    ->orWhere('nakshatram', 'like', "%{$search}%");

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Payment Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('payment_status')) {

            $query->where(
                'payment_status',
                $request->payment_status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        |
        | Calculate these BEFORE pagination.
        |
        | This is important because $receipts after paginate(20)
        | contains only 20 records.
        |
        */

        $summaryQuery = clone $query;


        // Total receipts
        $totalCount = $summaryQuery->count();


        // Fully paid receipts
        $paidCount = (clone $summaryQuery)
            ->where('payment_status', 'paid')
            ->count();


        // Pending + partially paid
        $pendingCount = (clone $summaryQuery)
            ->whereIn(
                'payment_status',
                [
                    'pending',
                    'partially_paid'
                ]
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | COLLECTED AMOUNT
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Collected Amount = paid_amount
        |
        | Only receipts with payment_status = paid.
        |
        | This calculation is done directly in MySQL,
        | so pagination does NOT affect the result.
        |
        */

        $totalCollected = (float) (clone $summaryQuery)
            ->where('payment_status', 'paid')
            ->sum('paid_amount');


        /*
        |--------------------------------------------------------------------------
        | Paginated Receipts
        |--------------------------------------------------------------------------
        */

        $receipts = $query
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Send Data To Blade
        |--------------------------------------------------------------------------
        */

        return view(
            'temple.receipt-printing.index',
            compact(
                'receipts',
                'totalCount',
                'paidCount',
                'pendingCount',
                'totalCollected'
            )
        );
    }


    /**
     * Display a single receipt.
     */
    public function show(Receipt $receipt): View
    {
        $receipt->load('items.vazhipad');

        return view(
            'temple.receipt-printing.show',
            compact('receipt')
        );
    }


    /**
     * Display printable receipt.
     */
    public function print(Receipt $receipt): View
    {
        $receipt->load('items.vazhipad');

        return view(
            'temple.receipt-printing.print',
            compact('receipt')
        );
    }


    /**
     * Display payment form.
     */
    public function paymentForm(Receipt $receipt): View
    {
        $receipt->load('items.vazhipad');

        return view(
            'temple.receipt-printing.payment',
            compact('receipt')
        );
    }


    /**
     * Mark/update payment.
     */
    public function markPayment(
        Request $request,
        Receipt $receipt
    ): RedirectResponse {

        $validated = $request->validate([

            'payment_status' => [
                'required',
                'in:pending,paid,partially_paid,cancelled'
            ],

            'payment_method' => [
                'nullable',
                'in:cash,upi,card,bank_transfer'
            ],

            'paid_amount' => [
                'required',
                'numeric',
                'min:0'
            ],

        ]);


        $totalAmount = (float) $receipt->total_amount;

        $paidAmount = (float) $validated['paid_amount'];


        /*
        |--------------------------------------------------------------------------
        | Paid Amount Cannot Exceed Total
        |--------------------------------------------------------------------------
        */

        if ($paidAmount > $totalAmount) {

            return back()
                ->withErrors([
                    'paid_amount' =>
                        'Paid amount cannot be greater than the receipt total.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Paid Status
        |--------------------------------------------------------------------------
        */

        if (
            $validated['payment_status'] === 'paid'
            && $paidAmount != $totalAmount
        ) {

            return back()
                ->withErrors([
                    'paid_amount' =>
                        'For Paid status, paid amount must equal the total amount.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Partially Paid
        |--------------------------------------------------------------------------
        */

        if (
            $validated['payment_status'] === 'partially_paid'
            && (
                $paidAmount <= 0
                || $paidAmount >= $totalAmount
            )
        ) {

            return back()
                ->withErrors([
                    'paid_amount' =>
                        'Partially paid amount must be greater than 0 and less than the total amount.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Pending
        |--------------------------------------------------------------------------
        |
        | If status is pending, normally paid amount should be 0.
        |
        */

        if (
            $validated['payment_status'] === 'pending'
            && $paidAmount != 0
        ) {

            return back()
                ->withErrors([
                    'paid_amount' =>
                        'Pending payment must have a paid amount of 0.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Cancelled
        |--------------------------------------------------------------------------
        */

        if (
            $validated['payment_status'] === 'cancelled'
            && $paidAmount != 0
        ) {

            return back()
                ->withErrors([
                    'paid_amount' =>
                        'Cancelled payment must have a paid amount of 0.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Update Receipt
        |--------------------------------------------------------------------------
        */

        $receipt->update([

            'payment_status' =>
                $validated['payment_status'],

            'payment_method' =>
                $validated['payment_method'] ?? null,

            'paid_amount' =>
                $paidAmount,

            'paid_at' =>
                $validated['payment_status'] === 'paid'
                    ? now()
                    : null,

        ]);


        return redirect()
            ->route(
                'temple.receipt-printing.show',
                $receipt
            )
            ->with(
                'success',
                'Payment updated successfully.'
            );
    }
}