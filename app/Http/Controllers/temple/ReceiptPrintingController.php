<?php

namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReceiptPrintingController extends Controller
{
    // ...
    /**
     * Display all receipts for printing.
     */
    public function index(): View
    {
        $receipts = Receipt::with('items.vazhipad')
            ->latest('id')
            ->paginate(20);

        return view('temple.receipt-printing.index', compact('receipts'));
    }

    /**
     * Display a single receipt.
     */
    public function show(Receipt $receipt): View
    {
        $receipt->load('items.vazhipad');

        return view('temple.receipt-printing.show', compact('receipt'));
    }

    /**
     * Display printable receipt.
     */
    public function print(Receipt $receipt): View
    {
        $receipt->load('items.vazhipad');

        return view('temple.receipt-printing.print', compact('receipt'));
    }

    /**
     * Display payment form.
     */
    public function paymentForm(Receipt $receipt): View
    {
        $receipt->load('items.vazhipad');

        return view('temple.receipt-printing.payment', compact('receipt'));
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

        if ($paidAmount > $totalAmount) {
            return back()
                ->withErrors([
                    'paid_amount' =>
                        'Paid amount cannot be greater than the receipt total.'
                ])
                ->withInput();
        }

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

        if (
            $validated['payment_status'] === 'partially_paid'
            && ($paidAmount <= 0 || $paidAmount >= $totalAmount)
        ) {
            return back()
                ->withErrors([
                    'paid_amount' =>
                        'Partially paid amount must be greater than 0 and less than the total amount.'
                ])
                ->withInput();
        }

        $receipt->update([
            'payment_status' => $validated['payment_status'],
            'payment_method' => $validated['payment_method'] ?? null,
            'paid_amount' => $paidAmount,
            'paid_at' => $validated['payment_status'] === 'paid'
                ? now()
                : null,
        ]);

        return redirect()
            ->route(
                'temple.receipt-printing.show',
                $receipt
            )
            ->with('success', 'Payment updated successfully.');
    }
}

