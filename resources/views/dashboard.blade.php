@extends('layouts.app')
@section('title','Dashboard')

@section('content')

<div class="section-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Admin Dashboard</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ config('app.name','Laravel') }}</a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

            <ul class="nav nav-tabs page-header-tab">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#admin-Dashboard">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="section-body mt-4">
    <div class="container-fluid">

        {{-- FILTER --}}
        <form method="GET" action="">
            <button name="filter" value="day" class="btn btn-info">Today</button>
            <button name="filter" value="month" class="btn btn-primary">This Month</button>
            <button name="filter" value="year" class="btn btn-success">This Year</button>
        </form>

        <br>

        {{-- STAT CARDS --}}
        <div class="row clearfix row-deck">

            <div class="col-6 col-md-4 col-xl-3">
                <div class="card">
                    <div class="card-body ribbon text-center">
                        <h3 class="mb-0">{{ $salesCount ?? 0 }}</h3>
                        <span>Total Transactions</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-3">
                <div class="card">
                    <div class="card-body ribbon text-center">
                        <h3 class="mb-0">₹ {{ number_format($totalRevenue ?? 0,2) }}</h3>
                        <span>Total Revenue</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-3">
                <div class="card">
                    <div class="card-body ribbon text-center">
                        <h3 class="mb-0">₹ {{ number_format($totalCommission ?? 0,2) }}</h3>
                        <span>Total Commission Deducted</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-3">
                <div class="card">
                    <div class="card-body ribbon text-center">
                        <h3 class="mb-0">₹ {{ number_format($netEarning ?? 0,2) }}</h3>
                        <span>Net Earnings</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-3">
                <div class="card">
                    <div class="card-body ribbon text-center">
                        <h3 class="mb-0">{{ $referrals ?? 0 }}</h3>
                        <span>Total Referrals</span>
                    </div>
                </div>
            </div>

        </div>


        {{-- CHARTS --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="row">

            {{-- LINE CHART --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Earnings Trend</h3></div>
                    <div class="card-body">
                        <canvas id="lineChart" height="110"></canvas>
                    </div>
                </div>
            </div>

            {{-- BAR CHART --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3>Revenue Bar Chart</h3></div>
                    <div class="card-body">
                        <canvas id="barChart" height="110"></canvas>
                    </div>
                </div>
            </div>

            {{-- PIE CHART --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3>Revenue Distribution</h3></div>
                    <div class="card-body">
                        <canvas id="pieChart" height="110"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<script>
/* ---------- LINE CHART ---------- */
new Chart(document.getElementById('lineChart'),{
    type:'line',
    data:{
        labels:{!! json_encode($labels ?? []) !!},
        datasets:[{
            label:'Revenue Trend',
            data:{!! json_encode($data ?? []) !!},
            borderColor:"#36a2eb",
            backgroundColor:"rgba(54,162,235,0.3)",
            borderWidth:3,
            fill:true,
            tension:0.4
        }]
    }
});

/* ---------- BAR CHART ---------- */
new Chart(document.getElementById('barChart'),{
    type:'bar',
    data:{
        labels:{!! json_encode($labels ?? []) !!},
        datasets:[{
            label:'Revenue',
            data:{!! json_encode($data ?? []) !!},
            backgroundColor:"rgba(75,192,192,0.6)"
        }]
    }
});

/* ---------- PIE CHART ---------- */
new Chart(document.getElementById('pieChart'),{
    type:'pie',
    data:{
        labels:{!! json_encode($pieLabels ?? []) !!},
        datasets:[{
            data:{!! json_encode($pieData ?? []) !!},
            backgroundColor:["#36a2eb","#ff9f40","#4bc0c0"]
        }]
    }
});
</script>

@endsection
