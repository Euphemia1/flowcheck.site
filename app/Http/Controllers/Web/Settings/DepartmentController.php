<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Web\Controller;
use App\Models\Department;
use App\Models\User;
use App\Traits\LogsToAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;

class DepartmentController extends Controller
{
    use LogsToAudit;

    public function index(): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        $org  = Auth::user()->organisation;
        $depts = Department::where('organisation_id', $org->id)->with('manager')->paginate(20);
        return view('settings.departments.index', compact('depts'));
    }

    public function create(): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        $org   = Auth::user()->organisation;
        $users = User::where('organisation_id', $org->id)->where('is_active', true)->get(['id', 'name']);
        return view('settings.departments.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        $org = Auth::user()->organisation;

        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'manager_id' => ['nullable', 'uuid', 'exists:users,id'],
            'budget_allocated' => ['nullable', 'numeric', 'min:0'],
        ]);

        $dept = Department::create([
            'id'               => Str::uuid(),
            'organisation_id'  => $org->id,
            'name'             => $request->name,
            'manager_id'       => $request->manager_id,
            'budget_allocated' => $request->budget_allocated ?? 0,
            'budget_used'      => 0,
        ]);

        $this->logAudit('created', $dept);

        return redirect()->route('app.settings.departments.index')->with('success', 'Department created.');
    }

    public function edit(Department $department): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        abort_if($department->organisation_id !== Auth::user()->organisation_id, 403);
        $org   = Auth::user()->organisation;
        $users = User::where('organisation_id', $org->id)->where('is_active', true)->get(['id', 'name']);
        return view('settings.departments.edit', compact('department', 'users'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        abort_if($department->organisation_id !== Auth::user()->organisation_id, 403);

        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'manager_id' => ['nullable', 'uuid', 'exists:users,id'],
        ]);

        $department->update(['name' => $request->name, 'manager_id' => $request->manager_id]);
        $this->logAudit('updated', $department);

        return redirect()->route('app.settings.departments.index')->with('success', 'Department updated.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        abort_if($department->organisation_id !== Auth::user()->organisation_id, 403);

        $department->delete();
        $this->logAudit('deleted', $department);

        return redirect()->route('app.settings.departments.index')->with('success', 'Department deleted.');
    }
}
