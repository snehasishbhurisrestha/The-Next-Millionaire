<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Audit;
use App\Models\User;
use App\Models\AuditReport;
use App\Models\CertificationType;
use App\Models\AuditTracking;
use App\Models\AuditorWallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    /*public function index(){
        $user = Auth::user();
        if ($user->hasRole('User')) {
            return redirect()->route('user-dashboard');
        }

        $enquiry_list = [];
        $today_audit_list = [];
        $audit_assigned = 0;
        $audit_completed = 0;
        $wallet_amount = 0;
        $total_enquiry = 0;
        if(Auth::user()->hasRole('Super Admin')){
            $enquiry_list = Audit::whereDate('created_at',date('Y-m-d'))->orderBy('id','desc')->get();
        }elseif(Auth::user()->hasRole('Auditor')){
            $today_audit_list = Audit::whereDate('audit_date',date('Y-m-d'))->where('auditor_id',Auth::id())->orderBy('id','asc')->get();
            $enquiry_list = Audit::whereDate('created_at',date('Y-m-d'))->where('auditor_id',Auth::id())->orderBy('id','desc')->get();
            $audit_completed = Audit::where('auditor_id',Auth::id())->where('status','Complete')->count();
            $audit_assigned = Audit::where('auditor_id',Auth::id())->where('status','!=','Complete')->count();
            $wallet_amount = AuditorWallet::where('auditor_id', Auth::id())->value('amount') ?? 0;
        }else{
            $total_enquiry = Audit::where('user_id',Auth::id())->count();
        }

        return view('dashboard',compact('enquiry_list','today_audit_list','audit_completed','audit_assigned','wallet_amount','total_enquiry'));
    }*/

    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('User')) {
            return redirect()->route('user-dashboard');
        }
        
        $filter = request('filter','year'); // day / month / year

        if($filter == 'day'){
            $start = Carbon::today();
        } elseif($filter == 'month'){
            $start = Carbon::now()->startOfMonth();
        } else {
            $start = Carbon::now()->startOfYear();
        }

        $transactions = Transaction::where('status','success')
            ->where('created_at','>=',$start)
            ->get();

        // Totals
        $totalRevenue = $transactions->sum('amount');

        $commissionPercent = config('site.commission', 20); // CHANGE IF NEEDED
        $totalCommission = ($totalRevenue * $commissionPercent) / 100;

        $netEarning = $totalRevenue - $totalCommission;

        // Total transactions count
        $salesCount = $transactions->count();

        // Referrals
        $referrals = Transaction::whereNotNull('generated_from_user_id')->count();

        /* ---------- LINE + BAR CHART (date wise money) ---------- */
        $chart = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status','success')
            ->where('created_at','>=',$start)
            ->groupBy('date')
            ->orderBy('date','asc')
            ->get();

        $labels = $chart->pluck('date');
        $data   = $chart->pluck('total');

        /* ---------- PIE CHART ---------- */
        $pieLabels = ['Total Revenue','Commission','Net Earnings'];
        $pieData = [$totalRevenue,$totalCommission,$netEarning];

        return view('dashboard', compact(
            'filter',
            'salesCount',
            'totalRevenue',
            'totalCommission',
            'netEarning',
            'referrals',
            'labels',
            'data',
            'pieLabels',
            'pieData'
        ));
    }
}