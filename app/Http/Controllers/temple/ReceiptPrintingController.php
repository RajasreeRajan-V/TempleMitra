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
     * Display only receipts belonging to the logged-in temple.
     */
    public function index(Request $request): View
    {
        $templeId = session('temple_id');

        if (!$templeId) {
            abort(403, 'Temple login required.');
        }

        $query = Receipt::with('items.vazhipad')
            ->where('temple_id', $templeId)
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
        */

        $summaryQuery = clone $query;

        /*
        |--------------------------------------------------------------------------
        | TOTAL RECEIPTS
        |--------------------------------------------------------------------------
        */

        $totalCount = (clone $summaryQuery)->count();

        /*
        |--------------------------------------------------------------------------
        | PAID RECEIPTS COUNT
        |--------------------------------------------------------------------------
        */

        $paidCount = (clone $summaryQuery)
            ->where('payment_status', 'paid')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | PENDING RECEIPTS COUNT
        |--------------------------------------------------------------------------
        */

        $pendingStatuses = [
            'pending',
            'partially_paid',
        ];

        $pendingCount = (clone $summaryQuery)
            ->whereIn('payment_status', $pendingStatuses)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL COLLECTED
        |--------------------------------------------------------------------------
        */

        $totalCollected = (float) (clone $summaryQuery)
            ->where('payment_status', 'paid')
            ->sum('paid_amount');

        /*
        |--------------------------------------------------------------------------
        | TOTAL PENDING AMOUNT
        |--------------------------------------------------------------------------
        */

        $pendingTotalDue = (float) (clone $summaryQuery)
            ->whereIn('payment_status', $pendingStatuses)
            ->sum('total_amount');

        $pendingAlreadyPaid = (float) (clone $summaryQuery)
            ->whereIn('payment_status', $pendingStatuses)
            ->sum('paid_amount');

        /*
        |--------------------------------------------------------------------------
        | FINAL PENDING AMOUNT
        |--------------------------------------------------------------------------
        */

        $totalPending = max(
            0,
            $pendingTotalDue - $pendingAlreadyPaid
        );

        /*
        |--------------------------------------------------------------------------
        | PAGINATED RECEIPTS
        |--------------------------------------------------------------------------
        */

        $receipts = $query
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | SEND DATA TO BLADE
        |--------------------------------------------------------------------------
        */

        return view(
            'temple.receipt-printing.index',
            compact(
                'receipts',
                'totalCount',
                'paidCount',
                'pendingCount',
                'totalCollected',
                'totalPending'
            )
        );
    }

    /**
     * Show a receipt only if it belongs to the logged-in temple.
     */
    public function show(Receipt $receipt): View
    {
        $this->checkTempleOwnership($receipt);

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
        $this->checkTempleOwnership($receipt);

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
        $this->checkTempleOwnership($receipt);

        $receipt->load('items.vazhipad');

        return view(
            'temple.receipt-printing.payment',
            compact('receipt')
        );
    }

    /**
     * Mark / update payment.
     */
    public function markPayment(
        Request $request,
        Receipt $receipt
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | SECURITY CHECK
        |--------------------------------------------------------------------------
        */

        $this->checkTempleOwnership($receipt);

        /*
        |--------------------------------------------------------------------------
        | Validate Payment
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'payment_status' => [
                'required',
                'in:pending,paid,partially_paid,cancelled'
            ],

            'payment_method' => [
                'nullable',
                'in:cash,upi,card,bank_transfer,other'
            ],

            'transaction_id' => [
                'nullable',
                'string',
                'max:255'
            ],

            'paid_amount' => [
                'required',
                'numeric',
                'min:0'
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Receipt Total
        |--------------------------------------------------------------------------
        */

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
        | Transaction ID
        |--------------------------------------------------------------------------
        */

        $transactionId = $validated['transaction_id'] ?? null;

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

            'transaction_id' =>
                $transactionId,

            'paid_amount' =>
                $paidAmount,

            'paid_at' =>
                in_array(
                    $validated['payment_status'],
                    ['paid', 'partially_paid']
                )
                    ? now()
                    : null,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

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

    /**
     * Check whether the receipt belongs to the logged-in temple.
     */
    private function checkTempleOwnership(Receipt $receipt): void
    {
        $templeId = session('temple_id');

        if (!$templeId) {
            abort(403, 'Temple login required.');
        }

        if ($receipt->temple_id != $templeId) {
            abort(403, 'Unauthorized access.');
        }
    }
}