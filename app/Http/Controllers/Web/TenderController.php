<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreTenderRequest;
use App\Models\Boq;
use App\Models\Contract;
use App\Models\Tender;
use App\Models\TenderSubmission;
use App\Services\DocumentNumberGeneratorService;
use App\Traits\LogsToAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class TenderController extends Controller
{
    use LogsToAudit;

    public function __construct(private DocumentNumberGeneratorService $docService) {}

    public function index(): View
    {
        abort_if(!Auth::user()->can('view_tenders'), 403);
        $org = Auth::user()->organisation;

        $tenders = Tender::where('organisation_id', $org->id)
            ->withCount('submissions')
            ->with('boq', 'createdBy')
            ->latest()
            ->paginate(15);

        return view('tenders.index', compact('tenders'));
    }

    public function create(): View
    {
        abort_if(!Auth::user()->can('create_tenders'), 403);
        $org = Auth::user()->organisation;

        $boqs = Boq::where('organisation_id', $org->id)
            ->where('status', 'draft')
            ->get(['id', 'boq_number', 'project_name']);

        return view('tenders.create', compact('boqs'));
    }

    public function store(StoreTenderRequest $request): RedirectResponse
    {
        abort_if(!Auth::user()->can('create_tenders'), 403);
        $org = Auth::user()->organisation;

        $tender = Tender::create([
            'organisation_id'  => $org->id,
            'boq_id'           => $request->boq_id,
            'tender_number'    => $this->docService->generateTenderNumber($org),
            'title'            => $request->title,
            'type'             => $request->type,
            'publication_date' => $request->publication_date,
            'closing_date'     => $request->closing_date,
            'status'           => 'draft',
            'created_by'       => Auth::id(),
        ]);

        $this->logAudit('created', $tender, ['tender_number' => $tender->tender_number]);

        return redirect()->route('app.tenders.show', $tender)
            ->with('success', 'Tender ' . $tender->tender_number . ' created.');
    }

    public function show(Tender $tender): View
    {
        abort_if(!Auth::user()->can('view_tenders'), 403);
        abort_if($tender->organisation_id !== Auth::user()->organisation_id, 403);

        $tender->load('boq', 'submissions.vendor', 'createdBy');

        return view('tenders.show', compact('tender'));
    }

    public function publish(Tender $tender): RedirectResponse
    {
        abort_if(!Auth::user()->can('publish_tenders'), 403);
        abort_if($tender->organisation_id !== Auth::user()->organisation_id, 403);

        $tender->update(['status' => 'published']);
        $this->logAudit('published', $tender);

        return redirect()->back()->with('success', 'Tender published.');
    }

    public function close(Tender $tender): RedirectResponse
    {
        abort_if(!Auth::user()->can('close_tenders'), 403);
        abort_if($tender->organisation_id !== Auth::user()->organisation_id, 403);

        $tender->update(['status' => 'closed']);
        $this->logAudit('closed', $tender);

        return redirect()->back()->with('success', 'Tender closed.');
    }

    public function award(Tender $tender, TenderSubmission $submission): RedirectResponse
    {
        abort_if(!Auth::user()->can('close_tenders'), 403);
        abort_if($tender->organisation_id !== Auth::user()->organisation_id, 403);

        DB::transaction(function () use ($tender, $submission) {
            $org = Auth::user()->organisation;

            $tender->submissions()->where('id', '!=', $submission->id)
                ->update(['status' => 'unsuccessful']);

            $submission->update(['status' => 'awarded']);
            $tender->update(['status' => 'awarded']);

            Contract::create([
                'id'              => Str::uuid(),
                'organisation_id' => $org->id,
                'vendor_id'       => $submission->vendor_id,
                'contract_number' => app(DocumentNumberGeneratorService::class)->generateContractNumber($org),
                'title'           => 'Contract for ' . $tender->title,
                'type'            => 'fixed_price',
                'start_date'      => now(),
                'end_date'        => now()->addYear(),
                'value'           => $submission->bid_amount,
                'status'          => 'active',
                'created_by'      => Auth::id(),
            ]);
        });

        $this->logAudit('awarded', $tender, ['submission_id' => $submission->id]);

        return redirect()->back()->with('success', 'Tender awarded and contract created.');
    }
}
