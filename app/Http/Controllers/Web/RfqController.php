<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreRfqRequest;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\Rfq;
use App\Models\Vendor;
use App\Models\VendorQuote;
use App\Services\DocumentNumberGeneratorService;
use App\Traits\LogsToAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class RfqController extends Controller
{
    use LogsToAudit;

    public function __construct(private DocumentNumberGeneratorService $docService) {}

    public function index(): View
    {
        abort_if(!Auth::user()->can('view_rfqs'), 403);
        $org = Auth::user()->organisation;

        $rfqs = Rfq::where('organisation_id', $org->id)
            ->withCount('quotes')
            ->with('createdBy')
            ->latest()
            ->paginate(15);

        return view('rfqs.index', compact('rfqs'));
    }

    public function create(): View
    {
        abort_if(!Auth::user()->can('create_rfqs'), 403);
        $org = Auth::user()->organisation;

        $prs = PurchaseRequest::where('organisation_id', $org->id)
            ->where('status', 'approved')
            ->get(['id', 'pr_number', 'title']);

        $vendors = Vendor::where('organisation_id', $org->id)
            ->where('is_approved', true)
            ->get(['id', 'name', 'email']);

        return view('rfqs.create', compact('prs', 'vendors'));
    }

    public function store(StoreRfqRequest $request): RedirectResponse
    {
        $org = Auth::user()->organisation;

        $rfq = DB::transaction(function () use ($request, $org) {
            $rfq = Rfq::create([
                'organisation_id'    => $org->id,
                'purchase_request_id'=> $request->purchase_request_id,
                'rfq_number'         => $this->docService->generateRfqNumber($org),
                'title'              => $request->title,
                'description'        => $request->description,
                'deadline'           => $request->deadline,
                'status'             => 'sent',
                'created_by'         => Auth::id(),
            ]);

            $rfq->vendors()->attach($request->vendor_ids);
            return $rfq;
        });

        $this->logAudit('created', $rfq, ['rfq_number' => $rfq->rfq_number]);

        return redirect()->route('app.rfqs.show', $rfq)
            ->with('success', 'RFQ ' . $rfq->rfq_number . ' created and sent to vendors.');
    }

    public function show(Rfq $rfq): View
    {
        abort_if(!Auth::user()->can('view_rfqs'), 403);
        abort_if($rfq->organisation_id !== Auth::user()->organisation_id, 403);

        $rfq->load('vendors', 'quotes.vendor', 'purchaseRequest', 'createdBy');

        return view('rfqs.show', compact('rfq'));
    }

    public function close(Rfq $rfq): RedirectResponse
    {
        abort_if(!Auth::user()->can('close_rfqs'), 403);
        abort_if($rfq->organisation_id !== Auth::user()->organisation_id, 403);

        $rfq->update(['status' => 'closed']);
        $this->logAudit('closed', $rfq);

        return redirect()->back()->with('success', 'RFQ closed.');
    }

    public function selectQuote(Rfq $rfq, VendorQuote $quote): RedirectResponse
    {
        abort_if(!Auth::user()->can('create_purchase_orders'), 403);
        abort_if($rfq->organisation_id !== Auth::user()->organisation_id, 403);

        $po = DB::transaction(function () use ($rfq, $quote) {
            $org = Auth::user()->organisation;

            $po = PurchaseOrder::create([
                'organisation_id'    => $org->id,
                'purchase_request_id'=> $rfq->purchase_request_id,
                'vendor_id'          => $quote->vendor_id,
                'po_number'          => app(DocumentNumberGeneratorService::class)->generatePoNumber($org),
                'status'             => 'draft',
                'payment_terms'      => 'Net 30',
                'total_amount'       => $quote->total_amount,
            ]);

            $rfq->update(['status' => 'awarded']);
            $quote->update(['is_selected' => true]);

            return $po;
        });

        $this->logAudit('quote_selected', $rfq, ['vendor_id' => $quote->vendor_id, 'po_number' => $po->po_number]);

        return redirect()->route('app.purchase-orders.show', $po)
            ->with('success', 'Quote selected. Draft PO ' . $po->po_number . ' created.');
    }
}
