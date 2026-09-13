<?php

namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\Devotee;
use App\Models\Collection as TempleCollection;
use App\Models\TemplesRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TempleDashboardController extends Controller
{
    /**
     * Display the temple dashboard with live statistics.
     */
    public function index()
    {
        $today = Carbon::today();

        // ── Temple record (for heading) ────────────────────────────────────
        $templeId = session('temple_id');
        $temple   = $templeId
            ? TemplesRegistration::find($templeId)
            : null;

        // ── Today's Vazhipad bookings (receipts created today) ─────────────
        $todaysVazhipad = Receipt::whereDate('created_at', $today)->count();

        // ── Today's Hundi collection ───────────────────────────────────────
        // Sums the "Hundi" source from the collections table for today.
        // Falls back to total paid receipts if no Hundi entry exists.
        $todaysHundi = TempleCollection::whereDate('collection_date', $today)
            ->where('source', 'Hundi')
            ->sum('amount');

        if (!$todaysHundi) {
            $todaysHundi = Receipt::whereDate('created_at', $today)
                ->where('payment_status', 'paid')
                ->sum('total_amount');
        }

        // ── Registered devotees ────────────────────────────────────────────
        $registeredDevotees = Devotee::count();

        // ── Prasadam orders today ──────────────────────────────────────────
        // Counts all receipts created today as prasadam orders.
        $prasadamOrders = Receipt::whereDate('created_at', $today)->count();

        // ── Pending approvals (receipts with payment_status = pending) ─────
        $pendingApprovals = Receipt::where('payment_status', 'pending')->count();

        // ── Hundi chart: last 7 days ───────────────────────────────────────
        $chartData = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            $amount = TempleCollection::whereDate('collection_date', $date)
                ->where('source', 'Hundi')
                ->sum('amount');

            // Fall back to total paid receipts for that day if no Hundi record
            if (!$amount) {
                $amount = Receipt::whereDate('created_at', $date)
                    ->where('payment_status', 'paid')
                    ->sum('total_amount');
            }

            return [
                'label'  => $date->format('D'),
                'amount' => (float) $amount,
            ];
        });

        $chartLabels = $chartData->pluck('label')->toArray();
        $chartValues = $chartData->pluck('amount')->toArray();

        return view('temple.index', compact(
            'temple',
            'todaysVazhipad',
            'todaysHundi',
            'registeredDevotees',
            'prasadamOrders',
            'pendingApprovals',
            'chartLabels',
            'chartValues',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
