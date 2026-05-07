<?php

namespace App\Http\Controllers\Web;

use App\Models\AuditLog;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $org  = $user->organisation;
        $ytd  = now()->startOfYear()->toDateString();

        $pendingPrs = PurchaseRequest::where('organisation_id', $org->id)
            ->whereIn('status', ['submitted', 'under_review'])
            ->count();

        $totalSpend = PurchaseOrder::where('organisation_id', $org->id)
            ->whereIn('status', ['approved', 'partially_received', 'received', 'closed'])
            ->where('created_at', '>=', $ytd)
            ->sum('total_amount');

        $openPos = PurchaseOrder::where('organisation_id', $org->id)
            ->whereIn('status', ['approved', 'partially_received'])
            ->count();

        $pendingInvoices = Invoice::where('organisation_id', $org->id)
            ->whereIn('status', ['pending', 'pending_matching', 'under_review'])
            ->count();

        $prsByStatus = PurchaseRequest::where('organisation_id', $org->id)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $spendByDepartment = Department::where('organisation_id', $org->id)
            ->get()
            ->map(function ($dept) use ($org, $ytd) {
                $spend = PurchaseOrder::where('organisation_id', $org->id)
                    ->whereIn('status', ['approved', 'partially_received', 'received', 'closed'])
                    ->where('created_at', '>=', $ytd)
                    ->whereHas('purchaseRequest', fn($q) => $q->where('department_id', $dept->id))
                    ->sum('total_amount');
                return ['name' => $dept->name, 'spend' => $spend];
            })
            ->filter(fn($d) => $d['spend'] > 0)
            ->sortByDesc('spend')
            ->take(6)
            ->values();

        $expiringContracts = Contract::where('organisation_id', $org->id)
            ->whereIn('status', ['active', 'draft'])
            ->whereNotNull('end_date')
            ->where('end_date', '<=', now()->addDays(60))
            ->where('end_date', '>=', now())
            ->with('vendor')
            ->orderBy('end_date')
            ->take(5)
            ->get();

        $recentActivity = AuditLog::where('organisation_id', $org->id)
            ->with('user')
            ->latest()
            ->take(8)
            ->get();

        return view('analytics.dashboard', compact(
            'pendingPrs',
            'totalSpend',
            'openPos',
            'pendingInvoices',
            'prsByStatus',
            'spendByDepartment',
            'expiringContracts',
            'recentActivity',
        ));
    }
}
