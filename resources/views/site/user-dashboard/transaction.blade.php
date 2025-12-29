@extends('layouts.user-dashboard')

@section('title','Transactions')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800" style="color: white !important;">Transactions</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">Your Referral Earnings</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Amount (₹)</th>
                            {{-- <th>Earned From</th> --}}
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($referrals as $key => $trx)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>₹{{ number_format($trx->amount, 2) }}</td>
                                {{-- <td>
                                    {{ $trx->generatedFromUser?->name ?? 'N/A' }}
                                </td> --}}
                                <td>{{ $trx->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No referral transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection