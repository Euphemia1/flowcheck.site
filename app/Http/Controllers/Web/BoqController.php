<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreBoqRequest;
use App\Models\Boq;
use App\Models\BoqItem;
use App\Models\Tender;
use App\Services\DocumentNumberGeneratorService;
use App\Traits\LogsToAudit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class BoqController extends Controller
{
    use LogsToAudit;

    public function __construct(private DocumentNumberGeneratorService $docService) {}

    public function index(): View
    {
        abort_if(!Auth::user()->can('view_boqs'), 403);
        $org = Auth::user()->organisation;

        $boqs = Boq::where('organisation_id', $org->id)
            ->with('createdBy')
            ->latest()
            ->paginate(15);

        return view('boqs.index', compact('boqs'));
    }

    public function create(): View
    {
        abort_if(!Auth::user()->can('create_boqs'), 403);
        $org = Auth::user()->organisation;

        $tenders = Tender::where('organisation_id', $org->id)
            ->whereIn('status', ['draft', 'published'])
            ->get(['id', 'tender_number', 'title']);

        return view('boqs.create', compact('tenders'));
    }

    public function store(StoreBoqRequest $request): RedirectResponse
    {
        abort_if(!Auth::user()->can('create_boqs'), 403);
        $org = Auth::user()->organisation;

        $boq = DB::transaction(function () use ($request, $org) {
            $total = collect($request->items)->sum(fn($i) => ($i['quantity'] ?? 0) * ($i['unit_rate'] ?? 0));

            $boq = Boq::create([
                'organisation_id'      => $org->id,
                'project_name'         => $request->title,
                'boq_number'           => $this->docService->generateBoqNumber($org),
                'description'          => $request->description,
                'total_estimated_value'=> $total,
                'status'               => 'draft',
                'created_by'           => Auth::id(),
            ]);

            foreach ($request->items as $item) {
                BoqItem::create([
                    'boq_id'          => $boq->id,
                    'category'        => $item['category'] ?? 'General',
                    'description'     => $item['description'],
                    'unit_of_measure' => $item['unit_of_measure'],
                    'quantity'        => $item['quantity'],
                    'unit_rate'       => $item['unit_rate'],
                    'total_amount'    => ($item['quantity'] ?? 0) * ($item['unit_rate'] ?? 0),
                ]);
            }

            return $boq;
        });

        $this->logAudit('created', $boq, ['boq_number' => $boq->boq_number, 'total' => $boq->total_estimated_value]);

        return redirect()->route('app.boqs.show', $boq)
            ->with('success', 'BOQ ' . $boq->boq_number . ' created.');
    }

    public function show(Boq $boq): View
    {
        abort_if(!Auth::user()->can('view_boqs'), 403);
        abort_if($boq->organisation_id !== Auth::user()->organisation_id, 403);

        $boq->load('items', 'createdBy', 'tenders');
        $itemsByCategory = $boq->items->groupBy('category');

        return view('boqs.show', compact('boq', 'itemsByCategory'));
    }

    public function edit(Boq $boq): View
    {
        abort_if(!Auth::user()->can('update_boqs'), 403);
        abort_if($boq->organisation_id !== Auth::user()->organisation_id, 403);
        abort_if($boq->status !== 'draft', 403, 'Only draft BOQs can be edited.');

        $boq->load('items');

        return view('boqs.edit', compact('boq'));
    }

    public function update(StoreBoqRequest $request, Boq $boq): RedirectResponse
    {
        abort_if(!Auth::user()->can('update_boqs'), 403);
        abort_if($boq->organisation_id !== Auth::user()->organisation_id, 403);

        DB::transaction(function () use ($request, $boq) {
            $total = collect($request->items)->sum(fn($i) => ($i['quantity'] ?? 0) * ($i['unit_rate'] ?? 0));

            $boq->update(['project_name' => $request->title, 'description' => $request->description, 'total_estimated_value' => $total]);

            $boq->items()->delete();
            foreach ($request->items as $item) {
                BoqItem::create([
                    'boq_id'          => $boq->id,
                    'category'        => $item['category'] ?? 'General',
                    'description'     => $item['description'],
                    'unit_of_measure' => $item['unit_of_measure'],
                    'quantity'        => $item['quantity'],
                    'unit_rate'       => $item['unit_rate'],
                    'total_amount'    => ($item['quantity'] ?? 0) * ($item['unit_rate'] ?? 0),
                ]);
            }
        });

        $this->logAudit('updated', $boq);

        return redirect()->route('app.boqs.show', $boq)->with('success', 'BOQ updated.');
    }

    public function pdf(Boq $boq)
    {
        abort_if(!Auth::user()->can('view_boqs'), 403);
        abort_if($boq->organisation_id !== Auth::user()->organisation_id, 403);

        $boq->load('items', 'createdBy');
        $itemsByCategory = $boq->items->groupBy('category');
        $org = Auth::user()->organisation;

        $pdf = Pdf::loadView('pdf.boq', compact('boq', 'itemsByCategory', 'org'))->setPaper('a4');
        return $pdf->download($boq->boq_number . '.pdf');
    }
}
