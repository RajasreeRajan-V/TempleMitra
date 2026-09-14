<?php

namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use App\Models\TemplesRegistration;
use App\Models\TempleImage;
use App\Models\Receipt;
use App\Models\Devotee;
use App\Models\Collection as TempleCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TempleDashboardController extends Controller
{
    /**
     * Display the temple dashboard with live statistics.
     */
    public function index()
    {
        // ---------------------------------------------------------
        // Check temple login session
        // ---------------------------------------------------------
        $templeId = session('temple_id');

        if (!$templeId || !session('temple_logged_in')) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login to continue.');
        }

        // ---------------------------------------------------------
        // Get logged-in temple
        // ---------------------------------------------------------
        $temple = TemplesRegistration::find($templeId);

        // ---------------------------------------------------------
        // Check temple exists and is active
        // ---------------------------------------------------------
        if (!$temple || $temple->status !== 'active') {

            session()->forget([
                'temple_id',
                'temple_name',
                'temple_email',
                'temple_logged_in',
            ]);

            return redirect()
                ->route('login')
                ->with('error', 'Your temple account is inactive.');
        }

        // ---------------------------------------------------------
        // Today's date
        // ---------------------------------------------------------
        $today = Carbon::today();

        // ---------------------------------------------------------
        // Get temple gallery image
        // ---------------------------------------------------------
        $templeImages = TempleImage::where('temple_id', $temple->id)
            ->first();

        // ---------------------------------------------------------
        // Today's Vazhipad bookings
        // Receipts created today
        // ---------------------------------------------------------
        $todaysVazhipad = Receipt::whereDate('created_at', $today)
            ->count();

        // ---------------------------------------------------------
        // Today's Hundi collection
        // ---------------------------------------------------------
        $todaysHundi = TempleCollection::whereDate(
                'collection_date',
                $today
            )
            ->where('source', 'Hundi')
            ->sum('amount');

        // If no Hundi collection exists,
        // use today's paid receipt total as fallback.
        if (!$todaysHundi) {
            $todaysHundi = Receipt::whereDate('created_at', $today)
                ->where('payment_status', 'paid')
                ->sum('total_amount');
        }

        // ---------------------------------------------------------
        // Registered devotees
        // ---------------------------------------------------------
        $registeredDevotees = Devotee::count();

        // ---------------------------------------------------------
        // Today's Prasadam orders
        // ---------------------------------------------------------
        $prasadamOrders = Receipt::whereDate('created_at', $today)
            ->count();

        // ---------------------------------------------------------
        // Pending approvals
        // ---------------------------------------------------------
        $pendingApprovals = Receipt::where(
            'payment_status',
            'pending'
        )->count();

        // ---------------------------------------------------------
        // Hundi chart - Last 7 days
        // ---------------------------------------------------------
        $chartData = collect(range(6, 0))->map(function ($daysAgo) {

            $date = Carbon::today()->subDays($daysAgo);

            // Get Hundi collection for this day
            $amount = TempleCollection::whereDate(
                    'collection_date',
                    $date
                )
                ->where('source', 'Hundi')
                ->sum('amount');

            // If no Hundi record exists,
            // fall back to paid receipts for that day.
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

        // ---------------------------------------------------------
        // Chart labels and values
        // ---------------------------------------------------------
        $chartLabels = $chartData
            ->pluck('label')
            ->toArray();

        $chartValues = $chartData
            ->pluck('amount')
            ->toArray();

        // ---------------------------------------------------------
        // Send all data to dashboard view
        // ---------------------------------------------------------
        return view('temple.index', compact(
            'temple',
            'templeImages',
            'todaysVazhipad',
            'todaysHundi',
            'registeredDevotees',
            'prasadamOrders',
            'pendingApprovals',
            'chartLabels',
            'chartValues'
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