<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vazhipad Report — {{ $from }} to {{ $to }}</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; color: #1a1a1a; padding: 24px; }
  .header { text-align: center; border-bottom: 2px solid #7c1f2c; padding-bottom: 12px; margin-bottom: 20px; }
  .header h1 { font-size: 20px; color: #7c1f2c; }
  .header p  { font-size: 12px; color: #555; margin-top: 4px; }
  .summary   { display: flex; gap: 16px; margin-bottom: 20px; }
  .stat-box  { flex: 1; border: 1px solid #e2c97e; border-radius: 6px; padding: 12px; text-align: center; background: #fffdf5; }
  .stat-box .label { font-size: 10px; color: #7c5c20; text-transform: uppercase; letter-spacing: .05em; }
  .stat-box .value { font-size: 18px; font-weight: 700; color: #7c1f2c; margin-top: 4px; }
  table { width: 100%; border-collapse: collapse; }
  th    { background: #7c1f2c; color: #fff; padding: 8px 10px; text-align: left; font-size: 11px; }
  td    { padding: 7px 10px; border-bottom: 1px solid #eee; }
  tr:nth-child(even) td { background: #fdf9f0; }
  tfoot td { font-weight: 700; background: #fdf0e0; border-top: 2px solid #7c1f2c; }
  .footer { text-align: center; margin-top: 24px; font-size: 10px; color: #888; }
  @media print { body { padding: 0; } .no-print { display: none !important; } }
</style>
</head>
<body>

<div class="no-print" style="text-align:right; margin-bottom:16px;">
  <button onclick="window.print()" style="padding:8px 20px; background:#7c1f2c; color:#fff; border:none; border-radius:4px; cursor:pointer; font-size:13px;">🖨 Print / Save as PDF</button>
  <button onclick="window.close()" style="padding:8px 16px; background:#eee; border:none; border-radius:4px; cursor:pointer; font-size:13px; margin-left:8px;">✕ Close</button>
</div>

<div class="header">
  <h1>Vazhipad Report</h1>
  <p>Period: {{ \Carbon\Carbon::parse($from)->format('d M Y') }} — {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</p>
  <p>Generated on: {{ now()->format('d M Y, h:i A') }}</p>
</div>

<div class="summary">
  <div class="stat-box">
    <div class="label">Vazhipad Types</div>
    <div class="value">{{ $summary->count() }}</div>
  </div>
  <div class="stat-box">
    <div class="label">Total Bookings</div>
    <div class="value">{{ $summary->sum('bookings_count') }}</div>
  </div>
  <div class="stat-box">
    <div class="label">Total Revenue</div>
    <div class="value">₹{{ number_format($summary->sum('total_amount'), 2) }}</div>
  </div>
</div>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Vazhipad Name</th>
      <th style="text-align:right">Bookings</th>
      <th style="text-align:right">Total Amount (₹)</th>
    </tr>
  </thead>
  <tbody>
    @forelse($summary as $i => $v)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $v->name }}</td>
        <td style="text-align:right">{{ $v->bookings_count }}</td>
        <td style="text-align:right">{{ number_format($v->total_amount ?? 0, 2) }}</td>
      </tr>
    @empty
      <tr><td colspan="4" style="text-align:center; padding:20px; color:#888;">No vazhipad data found.</td></tr>
    @endforelse
  </tbody>
  <tfoot>
    <tr>
      <td colspan="2" style="text-align:right">Total</td>
      <td style="text-align:right">{{ $summary->sum('bookings_count') }}</td>
      <td style="text-align:right">₹{{ number_format($summary->sum('total_amount'), 2) }}</td>
    </tr>
  </tfoot>
</table>

<div class="footer">TempleMitra — Confidential Report</div>
</body>
</html>
