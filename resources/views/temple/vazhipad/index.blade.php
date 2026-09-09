@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Vazhipad Details</h4>

        <a href="{{ route('temple.vazhipad.create') }}"
           class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Add Vazhipad
        </a>
    </div>

    @forelse($vazhipads as $vazhipad)

        <div class="card mb-3">
            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <h5>
                            {{ $vazhipad->name }}
                        </h5>

                        <p class="mb-1">
                            <strong>Description:</strong>
                            {{ $vazhipad->description ?? '—' }}
                        </p>

                        <p class="mb-1">
                            <strong>Price:</strong>
                            ₹{{ number_format($vazhipad->price, 2) }}
                        </p>

                        <p class="mb-0">
                            <strong>Status:</strong>

                            <span class="badge
                                {{ $vazhipad->status === 'active'
                                    ? 'bg-success'
                                    : 'bg-secondary' }}">

                                {{ ucfirst($vazhipad->status) }}

                            </span>
                        </p>

                    </div>

                    <div>

                        <a href="{{ route('temple.vazhipad.edit', $vazhipad->id) }}"
                           class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                            Edit
                        </a>

                        <a href="{{ route('temple.vazhipad.show', $vazhipad->id) }}"
                           class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i>
                            View
                        </a>

                    </div>

                </div>

            </div>
        </div>

    @empty

        <div class="alert alert-info">
            No Vazhipad records found.
        </div>

    @endforelse

</div>

@endsection

