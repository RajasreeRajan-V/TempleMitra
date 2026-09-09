{{--
    ADD THIS to your existing sidebar/nav partial (e.g. resources/views/layouts/partials/sidebar.blade.php),
    right next to (not replacing) your existing "Receipts" menu item.

    Adjust the wrapper element (li/a classes, icon markup) to match your
    existing menu's markup style — this is written for a generic Bootstrap
    sidebar and uses `request()->routeIs()` for the active state.
--}}

<li class="nav-item">
    <a
        href="{{ route('temple.receipts.index') }}"
        class="nav-link {{ request()->routeIs('temple.receipts.*') ? 'active' : '' }}"
    >
        <i class="bi bi-receipt"></i>
        <span>Receipts</span>
    </a>
</li>

{{-- ADDED: separate menu item for the new Receipt Printing module --}}
<li class="nav-item">
    <a
        href="{{ route('temple.receipt-printing.index') }}"
        class="nav-link {{ request()->routeIs('temple.receipt-printing.*') ? 'active' : '' }}"
    >
        <i class="bi bi-printer"></i>
        <span>Receipt Printing</span>
    </a>
</li>