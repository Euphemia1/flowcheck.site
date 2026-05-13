<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use App\Services\DocumentNumberGeneratorService;
use App\Services\ThreeWayMatchingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function __construct(
        protected DocumentNumberGeneratorService $docService,
        protected ThreeWayMatchingService $matchingService
    ) {}

    public function index(): View
    {
        $org = Auth::user()->organisation;
        $invoices = Invoice::where('organisation_id', $org->id)
            ->with('vendor', 'purchaseOrder')
            ->latest()
            ->paginate(15);

        return view('finance.invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $org = Auth::user()->organisation;
        $purchaseOrders = PurchaseOrder::where('organisation_id', $org->id)
            ->where('status', '!=', 'cancelled')
            ->get(['id', 'po_number']);
        $vendors = Vendor::where('organisation_id', $org->id)
            ->where('is_approved', true)
            ->get(['id', 'name']);

        return view('finance.invoices.create', compact('purchaseOrders', 'vendors'));
    }

    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        $org = Auth::user()->organisation;

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store("invoices/{$org->id}");
        }

        $invoice = Invoice::create([
            'organisation_id' => $org->id,
            'vendor_id' => $request->vendor_id,
            'purchase_order_id' => $request->purchase_order_id,
            'invoice_number' => $request->invoice_number,
            'internal_invoice_number' => $this->docService->generateInvoiceNumber($org),
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'total_amount' => $request->total_amount,
            'status' => 'received',
            'file_path' => $filePath,
        ]);

        // Perform 3-way matching
        if ($request->purchase_order_id) {
            $this->matchingService->matchInvoice($invoice);
        }

        return redirect()->route('app.invoices.show', $invoice)
            ->with('success', 'Invoice uploaded successfully');
    }

    public function show(Invoice $invoice): View
    {
        $this->authorize('view', $invoice);
        $invoice->load('vendor', 'purchaseOrder', 'matchingResults');

        return view('finance.invoices.show', compact('invoice'));
    }

    public function approve(Invoice $invoice): RedirectResponse
    {
        $this->authorize('approve', $invoice);

        $invoice->update(['status' => 'approved_for_payment']);

        return redirect()->back()
            ->with('success', 'Invoice approved for payment');
    }

    public function pdf(Invoice $invoice)
    {
        $this->authorize('view', $invoice);
        $invoice->load('vendor', 'purchaseOrder');
        $org = Auth::user()->organisation;

        $pdf = Pdf::loadView('pdf.invoice', compact('invoice', 'org'))->setPaper('a4');

        return $pdf->download($invoice->internal_invoice_number . '.pdf');
    }
}
