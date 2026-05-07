<?php

namespace App\Http\Controllers\Web;

use App\Models\BudgetLine;
use App\Models\Department;
use App\Traits\LogsToAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;

class BudgetController extends Controller
{
    use LogsToAudit;

    public function index(): View
    {
        abort_if(!Auth::user()->can('view_budgets'), 403);
        $org = Auth::user()->organisation;
        $fiscalYear = request('fiscal_year', now()->year);

        $budgets = BudgetLine::where('organisation_id', $org->id)
            ->where('fiscal_year', $fiscalYear)
            ->with('department')
            ->get();

        return view('budgets.index', compact('budgets', 'fiscalYear'));
    }

    public function create(): View
    {
        abort_if(!Auth::user()->can('manage_budgets'), 403);
        $org = Auth::user()->organisation;

        $departments = Department::where('organisation_id', $org->id)->get(['id', 'name']);

        return view('budgets.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_budgets'), 403);
        $org = Auth::user()->organisation;

        $request->validate([
            'department_id'    => ['required', 'uuid', 'exists:departments,id'],
            'fiscal_year'      => ['required', 'integer', 'min:2000', 'max:2100'],
            'allocated_amount' => ['required', 'numeric', 'min:0'],
            'category'         => ['nullable', 'string', 'max:100'],
        ]);

        $budget = BudgetLine::create([
            'id'               => Str::uuid(),
            'organisation_id'  => $org->id,
            'department_id'    => $request->department_id,
            'fiscal_year'      => $request->fiscal_year,
            'category'         => $request->category ?? 'General',
            'allocated_amount' => $request->allocated_amount,
            'committed_amount' => 0,
            'spent_amount'     => 0,
        ]);

        $this->logAudit('created', $budget, ['allocated' => $request->allocated_amount]);

        return redirect()->route('app.budgets.index')
            ->with('success', 'Budget line created.');
    }

    public function show(BudgetLine $budget): View
    {
        abort_if(!Auth::user()->can('view_budgets'), 403);
        abort_if($budget->organisation_id !== Auth::user()->organisation_id, 403);

        $budget->load('department');

        return view('budgets.show', compact('budget'));
    }

    public function update(Request $request, BudgetLine $budget): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_budgets'), 403);
        abort_if($budget->organisation_id !== Auth::user()->organisation_id, 403);

        $request->validate(['allocated_amount' => ['required', 'numeric', 'min:0']]);

        $budget->update(['allocated_amount' => $request->allocated_amount]);
        $this->logAudit('updated', $budget, ['allocated_amount' => $request->allocated_amount]);

        return redirect()->back()->with('success', 'Budget updated.');
    }
}
