@extends('temple.layouts.app')

@section('title', 'View Vazhipad')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Vazhipad Details</h4>
        <div>
           <a href="{{ route('temple.vazhipad.edit', $vazhipad->id) }}" class="btn btn-primary btn-sm">
                <i class="fa fa-edit"></i> Edit
            </a>
            <a href="{{ route('temple.vazhipad.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                @if(!empty($vazhipad->image))
                <div class="col-md-3 text-center mb-3">
                    <img src="{{ asset('storage/'.$vazhipad->image) }}" class="img-fluid rounded">
                </div>
                @endif

                <div class="col-md-{{ !empty($vazhipad->image) ? '9' : '12' }}">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Vazhipad Name</th>
                            <td>{{ $vazhipad->name }}</td>
                        </tr>
                        <tr>
                            <th>Deity</th>
                            <td>{{ $vazhipad->deity ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>₹{{ number_format($vazhipad->price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($vazhipad->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $vazhipad->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $vazhipad->created_at?->format('d-m-Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection