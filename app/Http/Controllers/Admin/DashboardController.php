<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemplesRegistration;
use App\Models\Receipt;
use App\Models\Vazhipad;
use App\Models\Collection;
use App\Models\Devotee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $last7Days = Carbon::now()->subDays(6)->startOfDay();

        // ===== STAT CARDS =====

        // Total registered temples
        $totalTemples = TemplesRegistration::count();

        // Active temples
        $activeTemples = TemplesRegistration::where('status', 'active')->count();

        // Inactive temples
        $inactiveTemples = TemplesRegistration::where('status', 'inactive')->count();

        // New temples this month
        $newTemplesThisMonth = TemplesRegistration::where('created_at', '>=', $startOfMonth)->count();

        // Total devotees across platform
        $totalDevotees = Devotee::count();

        // Today's receipts count
        $todaysReceipts = Receipt::whereDate('receipts_date', $today)->count();

        // Today's revenue
        $todaysRevenue = Receipt::whereDate('receipts_date', $today)->sum('total_amount');

        // Monthly receipts count
        $monthlyReceipts = Receipt::where('receipts_date', '>=', $startOfMonth)->count();

        // Monthly revenue
        $monthlyRevenue = Receipt::where('receipts_date', '>=', $startOfMonth)->sum('total_amount');

        // Pending approvals (receipts with pending status)
        $pendingApprovals = Receipt::where('status', 'pending')->count();

        // Total collections
        $totalCollections = Collection::sum('amount');

        // Total vazhipads available
        $totalVazhipads = Vazhipad::count();

        // ===== REVENUE TREND (Last 7 Days) =====

        $revenueTrendRaw = Receipt::where('receipts_date', '>=', $last7Days)
            ->select(
                DB::raw('DATE(receipts_date) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        // Build labels & values for all 7 days (fill gaps with 0)
        $chartLabels = [];
        $chartValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateKey = $date->format('Y-m-d');

            $chartLabels[] = $date->format('D'); // Mon, Tue, ...
            $chartValues[] = (float) ($revenueTrendRaw[$dateKey] ?? 0);
        }

        // ===== DISTRICT-WISE TEMPLE COUNT =====

        $districtWiseTemples = TemplesRegistration::whereNotNull('district')
            ->where('district', '!=', '')
            ->select('district', DB::raw('COUNT(*) as count'))
            ->groupBy('district')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // ===== RECENT TEMPLE REGISTRATIONS =====

        $recentTemples = TemplesRegistration::latest()
            ->limit(5)
            ->get();

        // ===== GROWTH PERCENTAGE =====

        $lastMonthTemples = TemplesRegistration::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth(),
        ])->count();

        $growthPercentage = $lastMonthTemples > 0
            ? round((($newTemplesThisMonth - $lastMonthTemples) / $lastMonthTemples) * 100, 1)
            : 0;

        $inactivePercentage = $totalTemples > 0
            ? round(($inactiveTemples / $totalTemples) * 100)
            : 0;

        return view('admin.dashboard', compact(
            'totalTemples',
            'activeTemples',
            'inactiveTemples',
            'newTemplesThisMonth',
            'totalDevotees',
            'todaysReceipts',
            'todaysRevenue',
            'monthlyReceipts',
            'monthlyRevenue',
            'pendingApprovals',
            'totalCollections',
            'totalVazhipads',
            'chartLabels',
            'chartValues',
            'districtWiseTemples',
            'recentTemples',
            'growthPercentage',
            'inactivePercentage'
        ));
    }

public function templeList(Request $request)
{
    // Base query
    $query = TemplesRegistration::query();

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('temple_name', 'like', '%' . $search . '%')
              ->orWhere('location', 'like', '%' . $search . '%')
              ->orWhere('district', 'like', '%' . $search . '%')
              ->orWhere('registration_number', 'like', '%' . $search . '%');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Status Filter
    |--------------------------------------------------------------------------
    */
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    /*
    |--------------------------------------------------------------------------
    | District Filter
    |--------------------------------------------------------------------------
    */
    if ($request->filled('district')) {
        $query->where('district', $request->district);
    }

    /*
    |--------------------------------------------------------------------------
    | Temple List
    |--------------------------------------------------------------------------
    | paginate() keeps the filters when moving between pages.
    */
    $temples = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    | These are calculated separately so that the cards always show
    | the complete temple statistics, not only the current page.
    */
    $totalTemples = TemplesRegistration::count();

    $activeTemples = TemplesRegistration::where('status', 'active')->count();

    $inactiveTemples = TemplesRegistration::where('status', 'inactive')->count();

    /*
    |--------------------------------------------------------------------------
    | Percentages
    |--------------------------------------------------------------------------
    */
    $inactivePercentage = $totalTemples > 0
        ? round(($inactiveTemples / $totalTemples) * 100)
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Growth Percentage
    |--------------------------------------------------------------------------
    | Compare this month's registrations with the previous month.
    */
    $currentMonthCount = TemplesRegistration::whereBetween(
        'created_at',
        [
            now()->startOfMonth(),
            now()->endOfMonth()
        ]
    )->count();

    $previousMonthCount = TemplesRegistration::whereBetween(
        'created_at',
        [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth()
        ]
    )->count();

    if ($previousMonthCount > 0) {
        $growthPercentage = round(
            (($currentMonthCount - $previousMonthCount) / $previousMonthCount) * 100
        );
    } else {
        $growthPercentage = $currentMonthCount > 0 ? 100 : 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Districts
    |--------------------------------------------------------------------------
    */
    $districts = TemplesRegistration::query()
        ->whereNotNull('district')
        ->where('district', '!=', '')
        ->distinct()
        ->orderBy('district')
        ->pluck('district');

    $districtsCount = $districts->count();

    /*
    |--------------------------------------------------------------------------
    | Return View
    |--------------------------------------------------------------------------
    */
    return view('admin.temple_list', compact(
        'temples',
        'totalTemples',
        'activeTemples',
        'inactiveTemples',
        'inactivePercentage',
        'growthPercentage',
        'districts',
        'districtsCount'
    ));
}


}