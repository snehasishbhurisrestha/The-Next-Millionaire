@extends('layouts.app')

@section('title','Uncaptured Payment')

@section('style')
<style>
    td.review-full {
        white-space: normal !important;
        word-wrap: break-word;
        word-break: break-word;
        max-width: 450px; /* optional, can remove if you want full width */
    }

</style>
@endsection

@section('content')

<div class="section-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Uncaptured Payment</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Uncaptured Payment</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body mt-4">
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Uncaptured Payment Records</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>User</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($uncaptured_payments as $en)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $en->created_at->format('d M Y') }}</td>

                            <td>
                                {{ $en->user->name ?? '-' }} <br>
                                <small>{{ $en->user->email ?? '' }}</small>
                            </td>

                            <td>{{ $en->course->title ?? '-' }}</td>

                            <td>₹{{ $en->amount }}</td>

                            <td>
                                <button type="button" 
                                    class="btn btn-info btn-sm"
                                    data-toggle="modal" 
                                    data-target="#verifyPaymentModal">
                                    Verify Payment & Enroll
                                </button>
                            </td>
                        </tr>

                        <!-- Verify Payment Modal -->
                        <div class="modal fade" id="verifyPaymentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="verifyPaymentLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ route('admin.uncaptured-payment.process_payment') }}" method="POST">
                                        @csrf

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="verifyPaymentLabel">Verify Payment</h5>
                                            <button type="button" class="btn btn-close" data-dismiss="modal">x</button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label class="form-label">Transaction ID</label>
                                                <input type="text" name="transaction_id" class="form-control" required>
                                            </div>

                                            <input type="hidden" name="uncaptured_payment_id" value="{{ $en->id ?? '' }}">

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                Submit & Enroll
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No Uncaptured Payment found</td>
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
