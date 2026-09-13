<?php


namespace App\Http\Controllers\Temple;

use App\Http\Controllers\Controller;
use App\Models\Collection as TempleCollection;
use App\Models\Devotee;
use App\Models\Receipt;
use App\Models\Vazhipad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ReceiptReportController extends Controller
{
    public function index(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);

        $totals = [
            'receipts'         => Receipt::betweenDates($from, $to)->sum('total_amount'),
            'receipts_count'   => Receipt::betweenDates($from, $to)->count(),
            'collections'      => TempleCollection::whereDate('collection_date', '>=', $from)
                                    ->whereDate('collection_date', '<=', $to)
                                    ->sum('amount'),
            'vazhipad_receipts' => Receipt::betweenDates($from, $to)
                                    ->whereHas('items')
                                    ->sum('total_amount'),
            'devotees_count'   => Devotee::count(),
        ];

        return view('temple.reports.index', compact('totals', 'from', 'to'));
    }


    public function receipts(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);

        $query = Receipt::with(['items.vazhipad'])->betweenDates($from, $to);

        if ($paymentStatus = $request->input('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }

        if ($paymentMethod = $request->input('payment_method')) {
            $query->where('payment_method', $paymentMethod);
        }

        $totalAmount = (clone $query)->sum('total_amount');

        $receipts = $query->orderByDesc('receipt_date')->paginate(25)->withQueryString();

        $devotees = Devotee::orderBy('name')->get(['id', 'name']);

        return view('temple.reports.receipts',
            compact('receipts', 'totalAmount', 'from', 'to', 'devotees')
        );
    }


    public function collections(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);

        $query = TempleCollection::whereDate('collection_date', '>=', $from)
            ->whereDate('collection_date', '<=', $to);

        if ($source = $request->input('source')) {
            $query->where('source', 'like', "%{$source}%");
        }

        $totalAmount = (clone $query)->sum('amount');

        $bySource = (clone $query)
            ->selectRaw('source, SUM(amount) as total')
            ->groupBy('source')
            ->orderByDesc('total')
            ->get();

        $collections = $query->orderByDesc('collection_date')->paginate(25)->withQueryString();

        return view('temple.reports.collections',
            compact('collections', 'totalAmount', 'bySource', 'from', 'to')
        );
    }


  public function vazhipads(Request $request)
{
    $from = $request->input(
        'from_date',
        now()->startOfMonth()->format('Y-m-d')
    );

    $to = $request->input(
        'to_date',
        now()->format('Y-m-d')
    );

    /*
    |--------------------------------------------------------------------------
    | Get ALL ACTIVE Vazhipads
    |--------------------------------------------------------------------------
    */

    $vazhipads = Vazhipad::where('is_active', 1)
        ->orderBy('name')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Get Vazhipad count and income
    |--------------------------------------------------------------------------
    */

    $itemTotals = DB::table('receipt_items')
        ->join(
            'receipts',
            'receipt_items.receipt_id',
            '=',
            'receipts.id'
        )

        // IMPORTANT:
        // Your actual date column is receipts_date
        ->whereDate('receipts.receipts_date', '>=', $from)
        ->whereDate('receipts.receipts_date', '<=', $to)

        ->select(
            'receipt_items.vazhipad_id',

            // Total number performed
            DB::raw('SUM(receipt_items.quantity) as bookings_count'),

            // Amount is already the total amount for the item
            DB::raw('SUM(receipt_items.amount) as total_amount')
        )

        ->groupBy('receipt_items.vazhipad_id')
        ->get()
        ->keyBy('vazhipad_id');


    /*
    |--------------------------------------------------------------------------
    | Attach count and income to every active Vazhipad
    |--------------------------------------------------------------------------
    */

    $summary = $vazhipads->map(function ($vazhipad) use ($itemTotals) {

        $total = $itemTotals->get($vazhipad->id);

        $vazhipad->bookings_count = $total
            ? (int) $total->bookings_count
            : 0;

        $vazhipad->total_amount = $total
            ? (float) $total->total_amount
            : 0;

        return $vazhipad;
    });


    /*
    |--------------------------------------------------------------------------
    | Grand Total Income
    |--------------------------------------------------------------------------
    */

    $totalAmount = $summary->sum('total_amount');


    /*
    |--------------------------------------------------------------------------
    | Return Report
    |--------------------------------------------------------------------------
    */

    return view(
        'temple.reports.vazhipads',
        compact(
            'summary',
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
            'receipts as receipts_count' => fn ($q) => $q->betweenDates($from, $to),
        ])->withSum([
            'receipts as total_amount' => fn ($q) => $q->betweenDates($from, $to),
        ], 'total_amount');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $devotees = $query->orderByDesc('total_amount')->paginate(25)->withQueryString();

        return view('temple.reports.devotees',
            compact('devotees', 'from', 'to', 'search')
        );
    }


    public function daily(Request $request): View
    {
        $date = $request->input('date') ?: now()->toDateString();

        $receipts = Receipt::with(['items.vazhipad'])
            ->whereDate('created_at', $date)
            ->orderBy('created_at')
            ->get();

        $totalReceipts    = $receipts->count();
        $totalAmount      = $receipts->sum('total_amount');

        $paymentSummary = $receipts
            ->groupBy(fn ($r) => $r->payment_method ?: 'Unknown')
            ->map(fn ($items) => [
                'count'  => $items->count(),
                'amount' => $items->sum('total_amount'),
            ]);

        $collectionAmount = TempleCollection::whereDate('collection_date', $date)->sum('amount');
        $collectionCount  = TempleCollection::whereDate('collection_date', $date)->count();

        return view('temple.reports.daily',
            compact('date', 'receipts', 'totalReceipts', 'totalAmount',
                    'paymentSummary', 'collectionAmount', 'collectionCount')
        );
    }


    /* =========================================================================
     |  EXCEL (CSV) DOWNLOADS
     |=========================================================================
    */

    public function dailyExcel(Request $request)
    {
        $date     = $request->input('date') ?: now()->toDateString();
        $receipts = Receipt::with(['items.vazhipad'])
            ->whereDate('created_at', $date)
            ->orderBy('created_at')
            ->get();

        return response()->stream(function () use ($receipts, $date) {
            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, ["Daily Temple Report — {$date}"]);
            fputcsv($out, []);
            fputcsv($out, ['#', 'Receipt No', 'Devotee', 'Vazhipad(s)', 'Payment Method', 'Status', 'Amount (₹)']);

            foreach ($receipts as $i => $r) {
                $vazhipads = $r->items->pluck('vazhipad.name')->filter()->implode(', ') ?: '—';
                fputcsv($out, [
                    $i + 1,
                    $r->id,
                    $r->devotee_name ?? '—',
                    $vazhipads,
                    ucfirst($r->payment_method ?? '—'),
                    ucfirst($r->payment_status ?? '—'),
                    number_format($r->total_amount ?? 0, 2),
                ]);
            }

            fputcsv($out, []);
            fputcsv($out, ['', '', '', '', '', 'Total', number_format($receipts->sum('total_amount'), 2)]);
            fclose($out);
        }, 200, $this->csvHeaders("daily-report-{$date}.csv"));
    }

    public function dailyPdf(Request $request): View
    {
        $date     = $request->input('date') ?: now()->toDateString();
        $receipts = Receipt::with(['items.vazhipad'])
            ->whereDate('created_at', $date)
            ->orderBy('created_at')
            ->get();

        return view('temple.reports.pdf.daily', compact('date', 'receipts'));
    }


    public function receiptsExcel(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);

        $query = Receipt::with(['items.vazhipad'])->betweenDates($from, $to);
        if ($s = $request->input('payment_status')) {
            $query->where('payment_status', $s);
        }
        if ($m = $request->input('payment_method')) {
            $query->where('payment_method', $m);
        }

        $receipts = $query->orderByDesc('receipt_date')->get();

        return response()->stream(function () use ($receipts, $from, $to) {
            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, ["Receipts Report — {$from} to {$to}"]);
            fputcsv($out, []);
            fputcsv($out, ['#', 'Receipt No', 'Date', 'Devotee', 'Vazhipad(s)', 'Payment Method', 'Status', 'Amount (₹)']);

            foreach ($receipts as $i => $r) {
                $vazhipads = $r->items->pluck('vazhipad.name')->filter()->implode(', ') ?: '—';
                fputcsv($out, [
                    $i + 1,
                    $r->id,
                    optional($r->receipt_date)->format('d-m-Y') ?? optional($r->created_at)->format('d-m-Y') ?? '—',
                    $r->devotee_name ?? '—',
                    $vazhipads,
                    ucfirst($r->payment_method ?? '—'),
                    ucfirst($r->payment_status ?? '—'),
                    number_format($r->total_amount ?? 0, 2),
                ]);
            }

            fputcsv($out, []);
            fputcsv($out, ['', '', '', '', '', '', 'Total', number_format($receipts->sum('total_amount'), 2)]);
            fclose($out);
        }, 200, $this->csvHeaders("receipts-{$from}-to-{$to}.csv"));
    }

    public function receiptsPdf(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);
        $receipts = Receipt::with(['items.vazhipad'])
            ->betweenDates($from, $to)
            ->orderByDesc('receipt_date')
            ->get();

        return view('temple.reports.pdf.receipts', compact('receipts', 'from', 'to'));
    }


    public function collectionsExcel(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);
        $query = TempleCollection::whereDate('collection_date', '>=', $from)
            ->whereDate('collection_date', '<=', $to);
        if ($s = $request->input('source')) {
            $query->where('source', 'like', "%{$s}%");
        }
        $collections = $query->orderByDesc('collection_date')->get();

        return response()->stream(function () use ($collections, $from, $to) {
            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, ["Collections Report — {$from} to {$to}"]);
            fputcsv($out, []);
            fputcsv($out, ['#', 'Date', 'Source', 'Collected By', 'Remarks', 'Amount (₹)']);

            foreach ($collections as $i => $c) {
                fputcsv($out, [
                    $i + 1,
                    optional($c->collection_date)->format('d-m-Y') ?? '—',
                    $c->source,
                    $c->collected_by ?? '—',
                    $c->remarks ?? '—',
                    number_format($c->amount, 2),
                ]);
            }

            fputcsv($out, []);
            fputcsv($out, ['', '', '', '', 'Total', number_format($collections->sum('amount'), 2)]);
            fclose($out);
        }, 200, $this->csvHeaders("collections-{$from}-to-{$to}.csv"));
    }

    public function collectionsPdf(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);
        $collections = TempleCollection::whereDate('collection_date', '>=', $from)
            ->whereDate('collection_date', '<=', $to)
            ->orderByDesc('collection_date')
            ->get();
        $bySource = $collections->groupBy('source')->map(fn ($items) => $items->sum('amount'));

        return view('temple.reports.pdf.collections', compact('collections', 'bySource', 'from', 'to'));
    }


    public function vazhipadsExcel(Request $request)
{
    [$from, $to] = $this->resolveDateRange($request);

    $summary = \App\Models\ReceiptItem::query()
        ->selectRaw('
            vazhipad_id,
            SUM(quantity) as bookings_count,
            SUM(amount * quantity) as total_amount
        ')
        ->whereHas('receipt', function ($query) use ($from, $to) {
            $query->whereDate('receipts.receipts_date', '>=', $from)
->whereDate('receipts.receipts_date', '<=', $to);
        })
        ->with('vazhipad:id,name')
        ->groupBy('vazhipad_id')
        ->get()
        ->map(function ($item) {
            return (object) [
                'name' => $item->vazhipad->name ?? 'Unknown Vazhipad',
                'bookings_count' => (int) $item->bookings_count,
                'total_amount' => (float) $item->total_amount,
            ];
        })
        ->sortByDesc('total_amount')
        ->values();

    return response()->stream(function () use ($summary, $from, $to) {

        $out = fopen('php://output', 'w');

        fputs($out, "\xEF\xBB\xBF");

        fputcsv($out, [
            "Vazhipad Report — {$from} to {$to}"
        ]);

        fputcsv($out, []);

        fputcsv($out, [
            '#',
            'Vazhipad Name',
            'Performed',
            'Total Amount (₹)'
        ]);

        foreach ($summary as $i => $vazhipad) {

            fputcsv($out, [
                $i + 1,
                $vazhipad->name,
                $vazhipad->bookings_count,
                number_format($vazhipad->total_amount, 2),
            ]);
        }

        fputcsv($out, []);

        fputcsv($out, [
            '',
            'Total',
            $summary->sum('bookings_count'),
            number_format(
                $summary->sum('total_amount'),
                2
            ),
        ]);

        fclose($out);

    }, 200, $this->csvHeaders(
        "vazhipads-{$from}-to-{$to}.csv"
    ));
}

    public function vazhipadsPdf(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);
        $summary = Vazhipad::withCount([
            'receipts as bookings_count' => fn ($q) => $q->betweenDates($from, $to),
        ])->withSum([
            'receipts as total_amount' => fn ($q) => $q->betweenDates($from, $to),
        ], 'total_amount')
        ->orderByDesc('total_amount')
        ->get();

        return view('temple.reports.pdf.vazhipads', compact('summary', 'from', 'to'));
    }


    public function devoteesExcel(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);
        $devotees = Devotee::withCount([
            'receipts as receipts_count' => fn ($q) => $q->betweenDates($from, $to),
        ])->withSum([
            'receipts as total_amount' => fn ($q) => $q->betweenDates($from, $to),
        ], 'total_amount')
        ->orderByDesc('total_amount')
        ->get();

        return response()->stream(function () use ($devotees, $from, $to) {
            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, ["Devotees Report — {$from} to {$to}"]);
            fputcsv($out, []);
            fputcsv($out, ['#', 'Name', 'Phone', 'Email', 'Receipts', 'Total Contribution (₹)']);

            foreach ($devotees as $i => $d) {
                fputcsv($out, [
                    $i + 1,
                    $d->name,
                    $d->phone ?? '—',
                    $d->email ?? '—',
                    $d->receipts_count,
                    number_format($d->total_amount ?? 0, 2),
                ]);
            }

            fputcsv($out, []);
            fputcsv($out, ['', '', '', 'Total', $devotees->sum('receipts_count'), number_format($devotees->sum('total_amount'), 2)]);
            fclose($out);
        }, 200, $this->csvHeaders("devotees-{$from}-to-{$to}.csv"));
    }

    public function devoteesPdf(Request $request): View
    {
        [$from, $to] = $this->resolveDateRange($request);
        $devotees = Devotee::withCount([
            'receipts as receipts_count' => fn ($q) => $q->betweenDates($from, $to),
        ])->withSum([
            'receipts as total_amount' => fn ($q) => $q->betweenDates($from, $to),
        ], 'total_amount')
        ->orderByDesc('total_amount')
        ->get();

        return view('temple.reports.pdf.devotees', compact('devotees', 'from', 'to'));
    }


    /* =========================================================================
     |  HELPERS
     |=========================================================================
    */

   private function resolveDateRange(Request $request): array
{
    $today = now()->toDateString();

    $from = $request->input('from_date') ?: $today;
    $to   = $request->input('to_date') ?: $today;

    return [$from, $to];
}
    private function csvHeaders(string $filename): array
    {
        return [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];
    }
}