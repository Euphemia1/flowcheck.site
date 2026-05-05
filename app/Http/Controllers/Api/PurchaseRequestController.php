<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequestRequest;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Services\DocumentNumberGeneratorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    public function __construct(
        protected DocumentNumberGeneratorService $docService
    ) {}

    public function index(): JsonResponse
    {
        $org = Auth::user()->organisation;

        $prs = PurchaseRequest::where('organisation_id', $org->id)
            ->with('department:id,name', 'requester:id,name', 'currentApprover:id,name')
            ->latest()
            ->paginate(20);

        return response()->json($prs);
    }

    public function store(StorePurchaseRequestRequest $request): JsonResponse
    {
        $user = Auth::user();
        $org = $user->organisation;

        $totalAmount = collect($request->items)->sum(
            fn($item) => $item['quantity_requested'] * $item['unit_price_estimated']
        );

        $pr = DB::transaction(function () use ($request, $user, $org, $totalAmount) {
            $pr = PurchaseRequest::create([
                'organisation_id'        => $org->id,
                'department_id'          => $request->department_id,
                'requested_by'           => $user->id,
                'pr_number'              => $this->docService->generatePrNumber($org),
                'title'                  => $request->title,
                'description'            => $request->description,
                'justification'          => $request->justification,
                'required_by_date'       => $request->required_by_date,
                'priority'               => $request->priority,
                'total_estimated_amount' => $totalAmount,
                'status'                 => 'draft',
            ]);

            foreach ($request->items as $item) {
                PurchaseRequestItem::create([
                    'purchase_request_id'  => $pr->id,
                    'description'          => $item['description'],
                    'unit_of_measure'      => $item['unit_of_measure'],
                    'quantity_requested'   => $item['quantity_requested'],
                    'unit_price_estimated' => $item['unit_price_estimated'],
                    'total_estimated'      => $item['quantity_requested'] * $item['unit_price_estimated'],
                    'category'             => $item['category'] ?? null,
                ]);
            }

            return $pr;
        });

        return response()->json($pr->load('items'), 201);
    }

    public function show(PurchaseRequest $purchaseRequest): JsonResponse
    {
        $this->authorize('view', $purchaseRequest);

        $purchaseRequest->load('items', 'requester', 'department', 'currentApprover', 'approvalLogs.approver');

        return response()->json($purchaseRequest);
    }
}
