@extends('layouts.app')

@section('title','Withdraw Requests')

@section('content')

<div class="section-body">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Withdraw Requests</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Withdraw Requests</li>
                </ol>
            </div>
        </div>

    </div>
</div>


<div class="section-body mt-4">
<div class="container-fluid">
<div class="card mt-4">

<div class="card-header">
    <h5 class="card-title">Pending / Completed Withdrawals</h5>
</div>

<div class="card-body">

<div class="table-responsive">
<table class="table table-bordered">
<thead>
<tr>
<th>User</th>
<th>Amount</th>
<th>Method</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@forelse($withdraws as $w)

<tr>
<td>{{ $w->user->name }}</td>
<td>₹{{ $w->amount }}</td>
<td>{{ strtoupper($w->payment_method) }}</td>
<td>
<span class="badge badge-{{ $w->status == 'pending' ? 'warning' : ($w->status=='success'?'success':'danger') }}">
{{ ucfirst($w->status) }}
</span>
</td>
<td>{{ $w->created_at->format('d M Y') }}</td>

<td>

@if($w->status == 'pending')

<form action="{{ route('admin.withdraw.approve',$w->id) }}" method="POST" style="display:inline-block">
@csrf
<button class="btn btn-success btn-sm">Approve</button>
</form>

<form action="{{ route('admin.withdraw.reject',$w->id) }}" method="POST" style="display:inline-block">
@csrf
<button class="btn btn-danger btn-sm">Reject</button>
</form>

@else
<span class="text-muted">No Action</span>
@endif

</td>
</tr>

@empty
<tr>
<td colspan="6" class="text-center text-muted">No Records Found</td>
</tr>
@endforelse

</tbody>
</table>
</div>

<div class="mt-3">
{{ $withdraws->links() }}
</div>

</div>
</div>
</div>
</div>

@endsection
