<?php

namespace App\Http\Controllers\Web;

use App\Models\Organisation;
use App\Models\PurchaseRequest;
use App\Models\Invoice;
use App\Models\Vendor;
use App\Models\Department;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $org = $user->organisation;

        // Get stats for dashboard
        $pendingPrs = PurchaseRequest::where('organisation_id', $org->id)
            ->where('status', 'under_review')
            ->count();

        $totalSpend = PurchaseRequest::where('organisation_id', $org->id)
            ->where('status', 'approved')
            ->sum('total_estimated_amount');

        $pendingInvoices = Invoice::where('organisation_id', $org->id)
            ->where('status', 'pending_matching')
            ->count();

        $vendors = Vendor::where('organisation_id', $org->id)
            ->where('is_approved', true)
            ->count();

        $prsByStatus = PurchaseRequest::where('organisation_id', $org->id)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $spendByDepartment = Department::where('organisation_id', $org->id)
            ->with('purchaseRequests')
            ->get()
            ->map(fn($dept) => [
                'name' => $dept->name,
                'spend' => $dept->purchaseRequests->sum('total_estimated_amount'),
            ]);

        return view('analytics.dashboard', compact(
            'pendingPrs',
            'totalSpend',
            'pendingInvoices',
            'vendors',
            'prsByStatus',
            'spendByDepartment',
            'org'
        ));
    }
}
