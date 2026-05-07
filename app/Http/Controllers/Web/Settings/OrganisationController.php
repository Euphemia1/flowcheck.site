<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Web\Controller;
use App\Models\Plan;
use App\Traits\LogsToAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class OrganisationController extends Controller
{
    use LogsToAudit;

    public function index(): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        return view('settings.index');
    }

    public function profile(): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        $org = Auth::user()->organisation;
        return view('settings.profile', compact('org'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        $org = Auth::user()->organisation;

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:10'],
            'industry' => ['nullable', 'string', 'max:100'],
            'country'  => ['nullable', 'string', 'max:10'],
            'logo'     => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg', 'max:2048'],
        ]);

        $logoPath = $org->settings['logo_path'] ?? null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store($org->id . '/logos', 'private');
        }

        $org->update([
            'name'     => $request->name,
            'currency' => $request->currency,
            'industry' => $request->industry,
            'country'  => $request->country,
            'settings' => array_merge($org->settings ?? [], ['logo_path' => $logoPath]),
        ]);

        $this->logAudit('updated', $org, ['name' => $request->name]);

        return redirect()->back()->with('success', 'Organisation profile updated.');
    }

    public function plans(): View
    {
        abort_if(!Auth::user()->can('manage_settings'), 403);
        $org  = Auth::user()->organisation;
        $plan = $org->plan;
        $all  = Plan::all();

        return view('settings.plans', compact('org', 'plan', 'all'));
    }
}
