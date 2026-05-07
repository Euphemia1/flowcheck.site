<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Budget;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Vendor;
use App\Exports\SpendByDepartmentExport;
use App\Exports\PurchaseRequestStatusExport;
use App\Exports\InvoiceAgingExport;
use App\Exports\VendorPerformanceExport;
use App\Exports\AuditTrailExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private function org()
    {
        return Auth::user()->organisation;
    }

    public function index()
    {
        abort_if(!Auth::user()->can('view_reports'), 403);
        return view('reports.index');
    }

    public function spendByDepartment(Request $request)
    {
        abort_if(!Auth::user()->can('view_reports'), 403);
        $org = $this->org();

        $from = $request->input('from', now()->startOfYear()->toDateString());
        $to   = $request->input('to', now()->toDateString());

        $rows = PurchaseOrder::where('organisation_id', $org->id)
            ->whereIn('status', ['approved', 'partially_received', 'received', 'closed'])
            ->whereBetween('created_at', [$from, $to])
            ->with('purchaseRequest.department')
            ->get()
            ->groupBy(fn($po) => $po->purchaseRequest?->department?->name ?? 'Unassigned')
            ->map(fn($pos, $dept) => [
                'department' => $dept,
                'total'      => $pos->sum('total_amount'),
                'count'      => $pos->count(),
            ])
            ->sortByDesc('total')
            ->values();

        if ($request->has('export')) {
            return Excel::download(new SpendByDepartmentExport($org->id, $from, $to), 'spend-by-department.xlsx');
        }

        return view('reports.spend-by-department', compact('rows', 'from', 'to'));
    }

    public function prStatus(Request $request)
    {
        abort_if(!Auth::user()->can('view_reports'), 403);
        $org = $this->org();

        $from = $request->input('from', now()->startOfYear()->toDateString());
        $to   = $request->input('to', now()->toDateString());

        $rows = PurchaseRequest::where('organisation_id', $org->id)
            ->whereBetween('created_at', [$from, $to])
            ->with(['department', 'requester'])
            ->orderByDesc('created_at')
            ->paginate(30)
            ->withQueryString();

        $summary = PurchaseRequest::where('organisation_id', $org->id)
            ->whereBetween('created_at', [$from, $to])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        if ($request->has('export')) {
            return Excel::download(new PurchaseRequestStatusExport($org->id, $from, $to), 'pr-status.xlsx');
        }

        return view('reports.pr-status', compact('rows', 'summary', 'from', 'to'));
    }

    public function invoiceAging(Request $request)
    {
        abort_if(!Auth::user()->can('view_reports'), 403);
        $org = $this->org();

        $invoices = Invoice::where('organisation_id', $org->id)
            ->whereNotIn('status', ['paid', 'void'])
            ->with('vendor')
            ->get()
            ->map(function ($inv) {
                $due = $inv->due_date ? now()->diffInDays($inv->due_date, false) : null;
                $inv->days_overdue = $due !== null && $due < 0 ? abs($due) : 0;
                $inv->aging_bucket = match (true) {
                    $due === null       => 'No Due Date',
                    $due >= 0           => 'Current',
                    $due >= -30         => '1-30 Days',
                    $due >= -60         => '31-60 Days',
                    $due >= -90         => '61-90 Days',
                    default             => '90+ Days',
                };
                return $inv;
            });

        $buckets = $invoices->groupBy('aging_bucket')
            ->map(fn($g) => ['count' => $g->count(), 'total' => $g->sum('amount')]);

        if ($request->has('export')) {
            return Excel::download(new InvoiceAgingExport($org->id), 'invoice-aging.xlsx');
        }

        return view('reports.invoice-aging', compact('invoices', 'buckets'));
    }

    public function vendorPerformance(Request $request)
    {
        abort_if(!Auth::user()->can('view_reports'), 403);
        $org = $this->org();

        $from = $request->input('from', now()->startOfYear()->toDateString());
        $to   = $request->input('to', now()->toDateString());

        $vendors = Vendor::where('organisation_id', $org->id)
            ->withCount(['purchaseOrders as po_count' => function ($q) use ($org, $from, $to) {
                $q->where('organisation_id', $org->id)->whereBetween('created_at', [$from, $to]);
            }])
            ->withSum(['purchaseOrders as total_spend' => function ($q) use ($org, $from, $to) {
                $q->where('organisation_id', $org->id)
                  ->whereIn('status', ['approved','partially_received','received','closed'])
                  ->whereBetween('created_at', [$from, $to]);
            }], 'total_amount')
            ->orderByDesc('total_spend')
            ->paginate(25)
            ->withQueryString();

        if ($request->has('export')) {
            return Excel::download(new VendorPerformanceExport($org->id, $from, $to), 'vendor-performance.xlsx');
        }

        return view('reports.vendor-performance', compact('vendors', 'from', 'to'));
    }

    public function auditTrail(Request $request)
    {
        abort_if(!Auth::user()->can('view_reports'), 403);
        $org = $this->org();

        $from     = $request->input('from', now()->subDays(30)->toDateString());
        $to       = $request->input('to', now()->toDateString());
        $model    = $request->input('model');
        $userId   = $request->input('user_id');

        $query = AuditLog::where('organisation_id', $org->id)
            ->whereBetween('created_at', [$from, $to])
            ->with('user')
            ->orderByDesc('created_at');

        if ($model) $query->where('model_type', $model);
        if ($userId) $query->where('user_id', $userId);

        $logs = $query->paginate(50)->withQueryString();

        $modelTypes = AuditLog::where('organisation_id', $org->id)
            ->distinct()->pluck('model_type');

        $users = \App\Models\User::where('organisation_id', $org->id)->get();

        if ($request->has('export')) {
            return Excel::download(new AuditTrailExport($org->id, $from, $to, $model, $userId), 'audit-trail.xlsx');
        }

        return view('reports.audit-trail', compact('logs', 'modelTypes', 'users', 'from', 'to', 'model', 'userId'));
    }

    public function budgetUtilisation(Request $request)
    {
        abort_if(!Auth::user()->can('view_reports'), 403);
        $org = $this->org();

        $fiscalYear = $request->input('fiscal_year', now()->year);

        $budgets = Budget::where('organisation_id', $org->id)
            ->where('fiscal_year', $fiscalYear)
            ->with('department')
            ->get()
            ->map(function ($b) {
                $b->utilisation_pct = $b->total_amount > 0
                    ? round(($b->spent_amount / $b->total_amount) * 100, 1)
                    : 0;
                return $b;
            })
            ->sortByDesc('utilisation_pct');

        $years = Budget::where('organisation_id', $org->id)
            ->distinct()->orderByDesc('fiscal_year')->pluck('fiscal_year');

        return view('reports.budget-utilisation', compact('budgets', 'years', 'fiscalYear'));
    }
}
