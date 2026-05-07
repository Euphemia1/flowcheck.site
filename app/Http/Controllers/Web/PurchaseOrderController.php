<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StorePurchaseOrderRequest;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\Vendor;
use App\Services\DocumentNumberGeneratorService;
use App\Traits\LogsToAudit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class PurchaseOrderController extends Controller
{
    use LogsToAudit;

    public function __construct(private DocumentNumberGeneratorService $docService) {}

    public function index(): View
    {
        abort_if(!Auth::user()->can('view_purchase_orders'), 403);
        $org = Auth::user()->organisation;

        $pos = PurchaseOrder::where('organisation_id', $org->id)
            ->with('vendor', 'purchaseRequest')
            ->latest()
            ->paginate(15);

        return view('purchase-orders.index', compact('pos'));
    }

    public function create(): View
    {
        abort_if(!Auth::user()->can('create_purchase_orders'), 403);
        $org = Auth::user()->organisation;

        $approvedPrs = PurchaseRequest::where('organisation_id', $org->id)
            ->where('status', 'approved')
            ->with('items')
            ->get();

        $vendors = Vendor::where('organisation_id', $org->id)
            ->where('is_approved', true)
            ->get(['id', 'name', 'payment_terms']);

        return view('purchase-orders.create', compact('approvedPrs', 'vendors'));
    }

    public function store(StorePurchaseOrderRequest $request): RedirectResponse
    {
        abort_if(!Auth::user()->can('create_purchase_orders'), 403);
        $org = Auth::user()->organisation;

        $po = DB::transaction(function () use ($request, $org) {
            $total = collect($request->items)->sum(fn($i) => $i['quantity'] * $i['unit_price']);

            $po = PurchaseOrder::create([
                'organisation_id'       => $org->id,
                'purchase_request_id'   => $request->purchase_request_id,
                'vendor_id'             => $request->vendor_id,
                'po_number'             => $this->docService->generatePoNumber($org),
                'status'                => 'draft',
                'payment_terms'         => $request->payment_terms,
                'delivery_address'      => $request->delivery_address,
                'expected_delivery_date'=> $request->expected_delivery_date,
                'total_amount'          => $total,
            ]);

            foreach ($request->items as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'description'       => $item['description'],
                    'unit_of_measure'   => $item['unit_of_measure'],
                    'quantity_ordered'  => $item['quantity'],
                    'unit_price'        => $item['unit_price'],
                    'total_price'       => $item['quantity'] * $item['unit_price'],
                ]);
            }

            return $po;
        });

        $this->logAudit('created', $po, ['po_number' => $po->po_number, 'total' => $po->total_amount]);

        return redirect()->route('app.purchase-orders.show', $po)
            ->with('success', 'Purchase Order ' . $po->po_number . ' created successfully.');
    }

    public function show(PurchaseOrder $purchaseOrder): View
    {
        abort_if(!Auth::user()->can('view_purchase_orders'), 403);
        $this->authoriseOrgAccess($purchaseOrder);

        $purchaseOrder->load('vendor', 'purchaseRequest.items', 'items', 'grns.items', 'invoices', 'approvedBy');

        return view('purchase-orders.show', compact('purchaseOrder'));
    }

    public function approve(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        abort_if(!Auth::user()->can('approve_purchase_orders'), 403);
        $this->authoriseOrgAccess($purchaseOrder);

        $purchaseOrder->update(['status' => 'sent', 'approved_by' => Auth::id()]);
        $this->logAudit('approved', $purchaseOrder, ['status' => 'sent']);

        return redirect()->back()->with('success', 'Purchase Order approved and sent.');
    }

    public function cancel(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        abort_if(!Auth::user()->can('cancel_purchase_orders'), 403);
        $this->authoriseOrgAccess($purchaseOrder);

        if ($purchaseOrder->grns()->exists()) {
            return redirect()->back()->with('error', 'Cannot cancel a PO with received goods.');
        }

        $purchaseOrder->update(['status' => 'cancelled']);
        $this->logAudit('cancelled', $purchaseOrder, ['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Purchase Order cancelled.');
    }

    public function pdf(PurchaseOrder $purchaseOrder)
    {
        abort_if(!Auth::user()->can('view_purchase_orders'), 403);
        $this->authoriseOrgAccess($purchaseOrder);
        $purchaseOrder->load('vendor', 'items', 'purchaseRequest', 'approvedBy');
        $org = Auth::user()->organisation;

        $pdf = Pdf::loadView('pdf.purchase-order', compact('purchaseOrder', 'org'))->setPaper('a4');

        return $pdf->download($purchaseOrder->po_number . '.pdf');
    }

    private function authoriseOrgAccess(PurchaseOrder $po): void
    {
        abort_if($po->organisation_id !== Auth::user()->organisation_id, 403);
    }
}
