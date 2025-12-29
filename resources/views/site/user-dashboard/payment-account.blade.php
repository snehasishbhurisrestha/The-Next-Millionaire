@extends('layouts.user-dashboard')

@section('title','Payment Account')

@section('content')

<h1 class="h3 mb-2 text-gray-800" style="color: white !important;">Payment Account Details</h1>

<div class="card shadow mb-4">
    <div class="card-body">

        <form action="{{ route('user.payment.account.update') }}" method="POST">
            @csrf

            {{-- <h5 class="text-primary text-dark">UPI Details</h5>
            <div class="form-group">
                <label>UPI ID</label>
                <input type="text" name="upi_id" class="form-control"
                       value="{{ auth()->user()->upi_id }}">
            </div>

            <hr> --}}

            <h5 class="text-primary text-dark">Bank Details</h5>

            <div class="form-group">
                <label>Bank Name</label>
                <input type="text" name="bank_name" class="form-control"
                       value="{{ auth()->user()->bank_name }}">
            </div>

            <div class="form-group">
                <label>Account Holder Name</label>
                <input type="text" name="account_name" class="form-control"
                       value="{{ auth()->user()->account_name }}">
            </div>

            <div class="form-group">
                <label>Account Number</label>
                <input type="text" name="account_number" class="form-control"
                       value="{{ auth()->user()->account_number }}">
            </div>

            <div class="form-group">
                <label>Confirm Account Number</label>
                <input type="text" name="confirm_account_number" class="form-control"
                       value="{{ auth()->user()->account_number }}">
            </div>

            <div class="form-group">
                <label>IFSC Code</label>
                <input type="text" name="ifsc_code" class="form-control"
                       value="{{ auth()->user()->ifsc_code }}">
            </div>

            <button class="btn btn-dark">Save</button>
        </form>
    </div>
</div>

@endsection
