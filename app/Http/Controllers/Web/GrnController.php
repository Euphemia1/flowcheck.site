<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreGrnRequest;
use App\Models\GoodsReceiptNote;
use App\Models\GrnItem;
use App\Models\PurchaseOrder;
use App\Services\DocumentNumberGeneratorService;
use App\Traits\LogsToAudit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class GrnController extends Controller
{
    use LogsToAudit;

    public function __construct(private DocumentNumberGeneratorService $docService) {}

    public function index(): View
    {
        abort_if(!Auth::user()->can('view_grns'), 403);
        $org = Auth::user()->organisation;

        $grns = GoodsReceiptNote::where('organisation_id', $org->id)
            ->with('purchaseOrder.vendor', 'receivedByUser')
            ->latest()
            ->paginate(15);

        return view('grns.index', compact('grns'));
    }

    public function create(): View
    {
        abort_if(!Auth::user()->can('create_grns'), 403);
        $org = Auth::user()->organisation;

        $poId = request('po');
        $pos = PurchaseOrder::where('organisation_id', $org->id)
            ->whereIn('status', ['sent', 'acknowledged', 'partially_received'])
            ->with('vendor', 'items')
            ->get();

        $selectedPo = $poId ? $pos->find($poId) : null;

        return view('grns.create', compact('pos', 'selectedPo'));
    }

    public function store(StoreGrnRequest $request): RedirectResponse
    {
        $org = Auth::user()->organisation;

        $grn = DB::transaction(function () use ($request, $org) {
            $filePath = null;
            if ($request->hasFile('delivery_note')) {
                $filePath = $request->file('delivery_note')->store(
                    $org->id . '/grns', 'private'
                );
            }

            $grn = GoodsReceiptNote::create([
                'organisation_id' => $org->id,
                'purchase_order_id'=> $request->purchase_order_id,
                'grn_number'      => $this->docService->generateGrnNumber($org),
                'received_by'     => Auth::id(),
                'received_at'     => now(),
                'status'          => 'received',
                'notes'           => $request->notes,
                'attachments'     => $filePath ? [$filePath] : null,
            ]);

            $totalOrdered = 0;
            $totalReceived = 0;

            foreach ($request->items as $item) {
                GrnItem::create([
                    'goods_receipt_note_id'  => $grn->id,
                    'purchase_order_item_id' => $item['purchase_order_item_id'],
                    'description'            => $item['description'],
                    'quantity_ordered'       => $item['quantity_ordered'],
                    'quantity_received'      => $item['quantity_received'],
                    'unit_of_measure'        => $item['unit_of_measure'],
                    'notes'                  => $item['notes'] ?? null,
                ]);
                $totalOrdered   += $item['quantity_ordered'];
                $totalReceived  += $item['quantity_received'];
            }

            $po = $grn->purchaseOrder;
            $newPoStatus = ($totalReceived >= $totalOrdered) ? 'received' : 'partially_received';
            $po->update(['status' => $newPoStatus]);

            return $grn;
        });

        $this->logAudit('created', $grn, ['grn_number' => $grn->grn_number]);

        return redirect()->route('app.grns.show', $grn)
            ->with('success', 'GRN ' . $grn->grn_number . ' recorded successfully.');
    }

    public function show(GoodsReceiptNote $grn): View
    {
        abort_if(!Auth::user()->can('view_grns'), 403);
        abort_if($grn->organisation_id !== Auth::user()->organisation_id, 403);

        $grn->load('purchaseOrder.vendor', 'items.purchaseOrderItem', 'receivedByUser');

        return view('grns.show', compact('grn'));
    }

    public function pdf(GoodsReceiptNote $grn)
    {
        abort_if(!Auth::user()->can('view_grns'), 403);
        abort_if($grn->organisation_id !== Auth::user()->organisation_id, 403);
        $grn->load('purchaseOrder.vendor', 'items', 'receivedByUser');
        $org = Auth::user()->organisation;

        $pdf = Pdf::loadView('pdf.grn', compact('grn', 'org'))->setPaper('a4');
        return $pdf->download($grn->grn_number . '.pdf');
    }
}
