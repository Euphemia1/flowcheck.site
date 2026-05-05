<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Services\DocumentNumberGeneratorService;
use App\Services\ThreeWayMatchingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function __construct(
        protected DocumentNumberGeneratorService $docService,
        protected ThreeWayMatchingService $matchingService
    ) {}

    public function index(): JsonResponse
    {
        $org = Auth::user()->organisation;

        $invoices = Invoice::where('organisation_id', $org->id)
            ->with('vendor:id,name', 'purchaseOrder:id,po_number')
            ->latest()
            ->paginate(20);

        return response()->json($invoices);
    }

    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        $org = Auth::user()->organisation;

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store("invoices/{$org->id}");
        }

        $invoice = Invoice::create([
            'organisation_id'          => $org->id,
            'vendor_id'                => $request->vendor_id,
            'purchase_order_id'        => $request->purchase_order_id,
            'invoice_number'           => $request->invoice_number,
            'internal_invoice_number'  => $this->docService->generateInvoiceNumber($org),
            'invoice_date'             => $request->invoice_date,
            'due_date'                 => $request->due_date,
            'total_amount'             => $request->total_amount,
            'status'                   => 'received',
            'file_path'                => $filePath,
        ]);

        if ($request->purchase_order_id) {
            $this->matchingService->matchInvoice($invoice);
        }

        return response()->json($invoice->load('vendor', 'purchaseOrder', 'matchingResults'), 201);
    }

    public function show(Invoice $invoice): JsonResponse
    {
        $this->authorize('view', $invoice);

        $invoice->load('vendor', 'purchaseOrder', 'matchingResults');

        return response()->json($invoice);
    }
}
