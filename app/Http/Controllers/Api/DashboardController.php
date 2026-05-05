<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PurchaseRequest;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $org = Auth::user()->organisation;
        $orgId = $org->id;

        $pendingPrs = PurchaseRequest::where('organisation_id', $orgId)
            ->whereIn('status', ['submitted', 'under_review'])
            ->count();

        $totalSpend = PurchaseRequest::where('organisation_id', $orgId)
            ->where('status', 'approved')
            ->sum('total_estimated_amount');

        $pendingInvoices = Invoice::where('organisation_id', $orgId)
            ->whereNotIn('status', ['paid', 'approved_for_payment'])
            ->count();

        $approvedVendors = Vendor::where('organisation_id', $orgId)
            ->where('is_approved', true)
            ->count();

        $prsByStatus = PurchaseRequest::where('organisation_id', $orgId)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $matchedInvoices = Invoice::where('organisation_id', $orgId)
            ->where('matching_status', 'matched')
            ->count();

        $totalInvoices = Invoice::where('organisation_id', $orgId)->count();

        return response()->json([
            'pending_prs'      => $pendingPrs,
            'total_spend'      => (float) $totalSpend,
            'pending_invoices' => $pendingInvoices,
            'approved_vendors' => $approvedVendors,
            'prs_by_status'    => $prsByStatus,
            'matching_rate'    => $totalInvoices > 0
                ? round($matchedInvoices / $totalInvoices * 100, 1)
                : 0,
        ]);
    }
}
