<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreContractRequest;
use App\Models\Contract;
use App\Models\Vendor;
use App\Services\DocumentNumberGeneratorService;
use App\Traits\LogsToAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class ContractController extends Controller
{
    use LogsToAudit;

    public function __construct(private DocumentNumberGeneratorService $docService) {}

    public function index(): View
    {
        abort_if(!Auth::user()->can('view_contracts'), 403);
        $org = Auth::user()->organisation;

        $contracts = Contract::where('organisation_id', $org->id)
            ->with('vendor')
            ->orderBy('end_date')
            ->paginate(15);

        return view('contracts.index', compact('contracts'));
    }

    public function create(): View
    {
        abort_if(!Auth::user()->can('create_contracts'), 403);
        $org = Auth::user()->organisation;

        $vendors = Vendor::where('organisation_id', $org->id)
            ->where('is_approved', true)
            ->get(['id', 'name']);

        return view('contracts.create', compact('vendors'));
    }

    public function store(StoreContractRequest $request): RedirectResponse
    {
        abort_if(!Auth::user()->can('create_contracts'), 403);
        $org = Auth::user()->organisation;

        $contract = DB::transaction(function () use ($request, $org) {
            $filePath = null;
            if ($request->hasFile('document')) {
                $filePath = $request->file('document')->store($org->id . '/contracts', 'private');
            }

            return Contract::create([
                'organisation_id' => $org->id,
                'vendor_id'       => $request->vendor_id,
                'contract_number' => $this->docService->generateContractNumber($org),
                'title'           => $request->title,
                'type'            => $request->type ?? 'fixed_price',
                'start_date'      => $request->start_date,
                'end_date'        => $request->end_date,
                'value'           => $request->value,
                'status'          => 'active',
                'document_path'   => $filePath,
                'created_by'      => Auth::id(),
            ]);
        });

        $this->logAudit('created', $contract, ['contract_number' => $contract->contract_number]);

        return redirect()->route('app.contracts.show', $contract)
            ->with('success', 'Contract ' . $contract->contract_number . ' created.');
    }

    public function show(Contract $contract): View
    {
        abort_if(!Auth::user()->can('view_contracts'), 403);
        abort_if($contract->organisation_id !== Auth::user()->organisation_id, 403);

        $contract->load('vendor', 'createdBy');

        return view('contracts.show', compact('contract'));
    }

    public function close(Contract $contract): RedirectResponse
    {
        abort_if(!Auth::user()->can('close_contracts'), 403);
        abort_if($contract->organisation_id !== Auth::user()->organisation_id, 403);

        $contract->update(['status' => 'terminated']);
        $this->logAudit('closed', $contract);

        return redirect()->back()->with('success', 'Contract closed.');
    }
}
