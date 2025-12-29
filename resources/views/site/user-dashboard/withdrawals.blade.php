@extends('layouts.user-dashboard')

@section('title','Withdrawals')

@section('content')

<h1 class="h3 mb-2 text-gray-800" style="color: white !important;">Withdrawals</h1>

<div class="mb-3">
    <a href="{{ route('user.payment.account') }}" class="btn btn-primary btn-sm mb-2">
        <i class="fas fa-wallet"></i> Update Payment Account
    </a>

    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#withdrawModal">
        <i class="fas fa-money-bill-wave"></i> Request Withdraw
    </button>
</div>



<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-dark">
            Withdrawal History
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Method</th>
                        <th>Account</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($withdrawals as $key => $w)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>₹{{ number_format($w->amount,2) }}</td>

                        <td>
                            @if($w->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($w->status == 'success')
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>

                        <td>{{ strtoupper($w->payment_method) }}</td>
                        <td>{{ $w->payment_account }}</td>
                        <td>{{ $w->created_at->format('d M Y h:i A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No withdrawal transactions found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



{{-- Withdraw Modal --}}
<div class="modal fade" id="withdrawModal">
    <div class="modal-dialog">
        <form action="{{ route('user.withdraw.request') }}" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Request Withdrawal</h5>
                    <button class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-info">
                        Wallet Balance:
                        <strong>₹{{ number_format(auth()->user()->wallet_balance,2) }}</strong>
                    </div>

                    <div class="alert alert-light">
                        <strong>Current Payment Account:</strong><br>
                        @if(auth()->user()->upi_id)
                            UPI: {{ auth()->user()->upi_id }}
                        @else
                            Bank: {{ auth()->user()->bank_name }} |
                            {{ auth()->user()->account_number }} |
                            {{ auth()->user()->ifsc_code }}
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" required min="1">
                    </div>

                    <p class="text-muted">
                        To change payment account,
                        <a href="{{ route('user.payment.account') }}">click here</a>.
                    </p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Submit</button>
                </div>

            </div>

        </form>
    </div>
</div>

@endsection
