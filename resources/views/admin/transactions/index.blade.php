@extends('layouts.app')

@section('title','Transactions')

@section('content')

<div class="section-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Transactions</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Transactions</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body mt-4">
<div class="container-fluid">
<div class="card mt-4">

<div class="card-header">
    <h5 class="card-title">All Transactions</h5>
</div>

<div class="card-body">

<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
    <th>#</th>
    <th>User</th>
    <th>Course</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Date</th>
</tr>
</thead>

<tbody>

@forelse($transactions as $t)

<tr>
<td>{{ $loop->iteration }}</td>

<td>
{{ $t->user->name ?? '' }} <br>
<small>{{ $t->user->email ?? '' }}</small>
</td>

<td>{{ $t->course->title ?? '-' }}</td>

<td>
<span class="badge badge-primary">
{{ ucfirst(str_replace('_',' ',$t->type)) }}
</span>
</td>

<td>₹{{ number_format($t->amount,2) }}</td>

<td>
<span class="badge badge-{{ $t->status == 'success' ? 'success' : ($t->status=='pending'?'warning':'danger') }}">
{{ ucfirst($t->status) }}
</span>
</td>

<td>{{ $t->created_at->format('d M Y') }}</td>
</tr>

@empty
<tr>
<td colspan="7" class="text-center text-muted">No transactions found</td>
</tr>
@endforelse

</tbody>
</table>
</div>

</div>
</div>
</div>
</div>

@endsection
