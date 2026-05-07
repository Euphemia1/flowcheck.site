<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Web\Controller;
use App\Models\ApprovalWorkflow;
use App\Models\Department;
use App\Models\User;
use App\Traits\LogsToAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;

class WorkflowController extends Controller
{
    use LogsToAudit;

    public function index(): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        $org = Auth::user()->organisation;

        $workflows = ApprovalWorkflow::where('organisation_id', $org->id)
            ->with('department')
            ->get();

        return view('settings.workflows.index', compact('workflows'));
    }

    public function create(): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        $org = Auth::user()->organisation;

        $departments = Department::where('organisation_id', $org->id)->get(['id', 'name']);
        $users       = User::where('organisation_id', $org->id)->where('is_active', true)->get(['id', 'name', 'email']);
        $roles       = ['org_admin', 'procurement_manager', 'finance_officer', 'cfo', 'department_head', 'procurement_officer'];

        return view('settings.workflows.create', compact('departments', 'users', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        $org = Auth::user()->organisation;

        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'uuid', 'exists:departments,id'],
            'min_amount'    => ['nullable', 'numeric', 'min:0'],
            'max_amount'    => ['nullable', 'numeric', 'min:0'],
            'steps'         => ['required', 'array', 'min:1'],
            'steps.*.step'  => ['required', 'integer'],
            'steps.*.approver_type' => ['required', 'in:role,user'],
            'steps.*.role'  => ['nullable', 'string'],
            'steps.*.user_id' => ['nullable', 'uuid'],
        ]);

        $workflow = ApprovalWorkflow::create([
            'id'              => Str::uuid(),
            'organisation_id' => $org->id,
            'name'            => $request->name,
            'department_id'   => $request->department_id,
            'min_amount'      => $request->min_amount,
            'max_amount'      => $request->max_amount,
            'steps'           => $request->steps,
        ]);

        $this->logAudit('created', $workflow);

        return redirect()->route('app.settings.workflows.index')->with('success', 'Workflow created.');
    }

    public function edit(ApprovalWorkflow $workflow): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        abort_if($workflow->organisation_id !== Auth::user()->organisation_id, 403);

        $org         = Auth::user()->organisation;
        $departments = Department::where('organisation_id', $org->id)->get(['id', 'name']);
        $users       = User::where('organisation_id', $org->id)->where('is_active', true)->get(['id', 'name', 'email']);
        $roles       = ['org_admin', 'procurement_manager', 'finance_officer', 'cfo', 'department_head', 'procurement_officer'];

        return view('settings.workflows.edit', compact('workflow', 'departments', 'users', 'roles'));
    }

    public function update(Request $request, ApprovalWorkflow $workflow): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        abort_if($workflow->organisation_id !== Auth::user()->organisation_id, 403);

        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'steps'  => ['required', 'array', 'min:1'],
        ]);

        $workflow->update([
            'name'          => $request->name,
            'department_id' => $request->department_id,
            'min_amount'    => $request->min_amount,
            'max_amount'    => $request->max_amount,
            'steps'         => $request->steps,
        ]);

        $this->logAudit('updated', $workflow);

        return redirect()->route('app.settings.workflows.index')->with('success', 'Workflow updated.');
    }

    public function destroy(ApprovalWorkflow $workflow): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        abort_if($workflow->organisation_id !== Auth::user()->organisation_id, 403);

        $workflow->delete();
        $this->logAudit('deleted', $workflow);

        return redirect()->route('app.settings.workflows.index')->with('success', 'Workflow deleted.');
    }
}
