@extends('layouts.app')

@section('content')

{{-- Added inline styles to guarantee the table looks correct even if external CSS fails --}}
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
        text-align: left;
    }
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
        background-color: #f8f9fa;
        font-weight: 600;
        white-space: nowrap;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.04);
    }
    .badge {
        display: inline-block;
        padding: 0.5em 0.75em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }
    .bg-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }
    .bg-success {
        background-color: #198754 !important;
        color: #fff !important;
    }
    .btn-sm-send {
        padding: 0.35rem 0.75rem;
        font-size: 0.8rem;
        border: none;
        border-radius: 0.375rem;
        background-color: #0d6efd;
        color: #fff;
        cursor: pointer;
    }
    .btn-sm-send:hover {
        background-color: #0b5ed7;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
</style>

<div class="page-header">
    <div class="page-header-left">
        <h1 class="page-title">Subscription Notifications</h1>
        <p class="page-subtitle">
            Temples that have completed their one-month free subscription
        </p>
    </div>

    <div class="page-header-right">
        <form method="POST" action="{{ route('admin.notifications.check') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                Check & Send Notifications
            </button>
        </form>
    </div>
</div>


{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
    </div>
@endif


{{-- Error Message --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
    </div>
@endif


<div class="card">
    <div class="card-header">
        <h2>One-Month Subscription Notifications</h2>
    </div>

    <div class="card-body">
        @if($notifications->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Temple Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subscription Start Date</th>
                            <th scope="col">Free Month Completed</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $notification->temple_name }}</strong>
                                </td>
                                <td>{{ $notification->email ?? 'No email' }}</td>
                                <td>
                                    {{ $notification->created_at
                                        ? $notification->created_at->format('d M Y h:i A')
                                        : '-' }}
                                </td>
                                <td>
                                    @if($notification->created_at)
                                        {{ $notification->created_at->copy()->addMonth()->format('d M Y h:i A') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(is_null($notification->one_month_notification_sent_at))
                                        <form method="POST" action="{{ route('admin.notifications.send', $notification->id) }}">
                                            @csrf
                                            <button type="submit" class="btn-sm-send">
                                                Send Notification
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-success">
                                            Mail Already Sent
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $notification->one_month_notification_sent_at->format('d M Y h:i A') }}
                                        </small>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">🔔</div>
                <h3>No Pending Subscription Notifications</h3>
                <p>
                    There are currently no temples that have completed
                    their one-month free subscription.
                </p>
                <small>
                    System check date: {{ now()->format('d M Y h:i A') }}
                </small>
            </div>
        @endif
    </div>
</div>

@endsection