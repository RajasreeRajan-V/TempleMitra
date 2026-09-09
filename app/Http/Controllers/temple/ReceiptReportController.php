<?php

namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use App\Models\Collection as TempleCollection;
use App\Models\Devotee;
use App\Models\Receipt;
use App\Models\Vazhipad;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReceiptReportController extends Controller
{
    public function index(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);

        $totals = [
            'receipts' => Receipt::betweenDates($from, $to)->sum('amount'),
            'receipts_count' => Receipt::betweenDates($from, $to)->count(),

            'collections' => TempleCollection::whereDate('collection_date', '>=', $from)
                ->whereDate('collection_date', '<=', $to)
                ->sum('amount'),

            'vazhipad_receipts' => Receipt::betweenDates($from, $to)
                ->where('type', 'vazhipad')
                ->sum('amount'),

            'devotees_count' => Devotee::count(),
        ];

        return view(
            'temple.reports.index',
            compact('totals', 'from', 'to')
        );
    }


    public function receipts(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);

        $query = Receipt::with([
            'devotee',
            'vazhipad',
            'collection'
        ])->betweenDates($from, $to);

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($devoteeId = $request->input('devotee_id')) {
            $query->where('devotee_id', $devoteeId);
        }

        if ($paymentMode = $request->input('payment_mode')) {
            $query->where('payment_mode', $paymentMode);
        }

        $totalAmount = (clone $query)->sum('amount');

        $receipts = $query
            ->orderByDesc('receipt_date')
            ->paginate(25)
            ->withQueryString();

        $devotees = Devotee::orderBy('name')
            ->get(['id', 'name']);

        return view(
            'temple.reports.receipts',
            compact(
                'receipts',
                'totalAmount',
                'from',
                'to',
                'devotees'
            )
        );
    }


    public function collections(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);

        $query = TempleCollection::whereDate(
            'collection_date',
            '>=',
            $from
        )->whereDate(
            'collection_date',
            '<=',
            $to
        );

        if ($source = $request->input('source')) {
            $query->where(
                'source',
                'like',
                "%{$source}%"
            );
        }

        $totalAmount = (clone $query)->sum('amount');

        $bySource = (clone $query)
            ->selectRaw('source, SUM(amount) as total')
            ->groupBy('source')
            ->orderByDesc('total')
            ->get();

        $collections = $query
            ->orderByDesc('collection_date')
            ->paginate(25)
            ->withQueryString();

        return view(
            'temple.reports.collections',
            compact(
                'collections',
                'totalAmount',
                'bySource',
                'from',
                'to'
            )
        );
    }


    public function vazhipads(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);

        $summary = Vazhipad::withCount([
            'receipts as bookings_count' => function ($q) use ($from, $to) {
                $q->betweenDates($from, $to);
            }
        ])
        ->withSum([
            'receipts as total_amount' => function ($q) use ($from, $to) {
                $q->betweenDates($from, $to);
            }
        ], 'amount')
        ->orderByDesc('total_amount')
        ->get();

        $receipts = Receipt::with([
            'devotee',
            'vazhipad'
        ])
        ->where('type', 'vazhipad')
        ->betweenDates($from, $to)
        ->orderByDesc('receipt_date')
        ->paginate(25)
        ->withQueryString();

        $totalAmount = $summary->sum('total_amount');

        return view(
            'temple.reports.vazhipads',
            compact(
                'summary',
                'receipts',
                'totalAmount',
                'from',
                'to'
            )
        );
    }


    public function devotees(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);

        $search = $request->input('search');

        $query = Devotee::withCount([
            'receipts as receipts_count' => function ($q) use ($from, $to) {
                $q->betweenDates($from, $to);
            }
        ])
        ->withSum([
            'receipts as total_amount' => function ($q) use ($from, $to) {
                $q->betweenDates($from, $to);
            }
        ], 'amount');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $devotees = $query
            ->orderByDesc('total_amount')
            ->paginate(25)
            ->withQueryString();

        return view(
            'temple.reports.devotees',
            compact(
                'devotees',
                'from',
                'to',
                'search'
            )
        );
    }


    /**
     * Daily temple report.
     */
    public function daily(Request $request): View
    {
        $date = $request->input('date')
            ?: now()->toDateString();

        /*
        |--------------------------------------------------------------------------
        | Daily Receipts
        |--------------------------------------------------------------------------
        */

        $receipts = Receipt::with([
            'devotee',
            'vazhipad',
            'collection'
        ])
            ->whereDate('receipt_date', $date)
            ->orderBy('receipt_date')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Receipt Summary
        |--------------------------------------------------------------------------
        */

        $totalReceipts = $receipts->count();

        $totalAmount = $receipts->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Payment Mode Summary
        |--------------------------------------------------------------------------
        */

        $paymentSummary = $receipts
            ->groupBy(function ($receipt) {
                return $receipt->payment_mode ?: 'Unknown';
            })
            ->map(function ($items) {
                return [
                    'count' => $items->count(),
                    'amount' => $items->sum('amount'),
                ];
            });


        /*
        |--------------------------------------------------------------------------
        | Receipt Type Summary
        |--------------------------------------------------------------------------
        */

        $typeSummary = $receipts
            ->groupBy(function ($receipt) {
                return $receipt->type ?: 'Other';
            })
            ->map(function ($items) {
                return [
                    'count' => $items->count(),
                    'amount' => $items->sum('amount'),
                ];
            });


        /*
        |--------------------------------------------------------------------------
        | Collection Summary
        |--------------------------------------------------------------------------
        */

        $collectionAmount = TempleCollection::whereDate(
            'collection_date',
            $date
        )->sum('amount');

        $collectionCount = TempleCollection::whereDate(
            'collection_date',
            $date
        )->count();


        return view(
            'temple.reports.daily',
            compact(
                'date',
                'receipts',
                'totalReceipts',
                'totalAmount',
                'paymentSummary',
                'typeSummary',
                'collectionAmount',
                'collectionCount'
            )
        );
    }


    private function resolveDateRange(Request $request): array
    {
        $from = $request->input('from_date')
            ?: now()->startOfMonth()->toDateString();

        $to = $request->input('to_date')
            ?: now()->toDateString();

        return [$from, $to];
    }
}   