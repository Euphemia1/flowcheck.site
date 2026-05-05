<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StorePurchaseRequestRequest;
use App\Models\Department;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Services\DocumentNumberGeneratorService;
use App\Services\ApprovalWorkflowService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    public function __construct(
        protected DocumentNumberGeneratorService $docService,
        protected ApprovalWorkflowService $approvalService
    ) {}

    public function index(): View
    {
        $org = Auth::user()->organisation;
        $prs = PurchaseRequest::where('organisation_id', $org->id)
            ->with('department', 'requester', 'currentApprover')
            ->latest()
            ->paginate(15);

        return view('procurement.purchase-requests.index', compact('prs'));
    }

    public function create(): View
    {
        $org = Auth::user()->organisation;
        $departments = Department::where('organisation_id', $org->id)
            ->get(['id', 'name']);

        return view('procurement.purchase-requests.create', compact('departments'));
    }

    public function store(StorePurchaseRequestRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $org = $user->organisation;

        $totalAmount = collect($request->items)->sum(fn($item) => 
            $item['quantity_requested'] * $item['unit_price_estimated']
        );

        $pr = DB::transaction(function () use ($request, $user, $org, $totalAmount) {
            $pr = PurchaseRequest::create([
                'organisation_id' => $org->id,
                'department_id' => $request->department_id,
                'requested_by' => $user->id,
                'pr_number' => $this->docService->generatePrNumber($org),
                'title' => $request->title,
                'description' => $request->description,
                'justification' => $request->justification,
                'required_by_date' => $request->required_by_date,
                'priority' => $request->priority,
                'total_estimated_amount' => $totalAmount,
                'status' => 'draft',
            ]);

            foreach ($request->items as $item) {
                PurchaseRequestItem::create([
                    'purchase_request_id' => $pr->id,
                    'description' => $item['description'],
                    'unit_of_measure' => $item['unit_of_measure'],
                    'quantity_requested' => $item['quantity_requested'],
                    'unit_price_estimated' => $item['unit_price_estimated'],
                    'total_estimated' => $item['quantity_requested'] * $item['unit_price_estimated'],
                    'category' => $item['category'] ?? null,
                ]);
            }

            return $pr;
        });

        return redirect()->route('app.purchase-requests.show', $pr)
            ->with('success', 'Purchase Request created successfully');
    }

    public function show(PurchaseRequest $purchaseRequest): View
    {
        $this->authorize('view', $purchaseRequest);
        $purchaseRequest->load('items', 'requester', 'department', 'approvalLogs.approver');

        return view('procurement.purchase-requests.show', compact('purchaseRequest'));
    }

    public function submit(PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $this->authorize('update', $purchaseRequest);

        $purchaseRequest->update(['status' => 'submitted']);
        
        $nextApprover = $this->approvalService->getNextApprover($purchaseRequest);
        if ($nextApprover) {
            $purchaseRequest->update([
                'current_approver_id' => $nextApprover->id,
                'status' => 'under_review',
            ]);
        }

        return redirect()->back()->with('success', 'PR submitted for approval');
    }

    public function approve(PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $this->authorize('approve', $purchaseRequest);

        $this->approvalService->logApproval($purchaseRequest, Auth::user(), 'approved');
        $this->approvalService->moveToNextStep($purchaseRequest);

        return redirect()->back()->with('success', 'PR approved');
    }

    public function reject(PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $this->authorize('reject', $purchaseRequest);

        $this->approvalService->logApproval($purchaseRequest, Auth::user(), 'rejected');
        $purchaseRequest->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'PR rejected');
    }
}
