<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreVendorRequest;
use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function index(): View
    {
        $org = Auth::user()->organisation;
        $vendors = Vendor::where('organisation_id', $org->id)
            ->latest()
            ->paginate(15);

        return view('vendors.index', compact('vendors'));
    }

    public function create(): View
    {
        return view('vendors.create');
    }

    public function store(StoreVendorRequest $request): RedirectResponse
    {
        $org = Auth::user()->organisation;

        Vendor::create([
            'organisation_id' => $org->id,
            ...$request->validated(),
        ]);

        return redirect()->route('app.vendors.index')
            ->with('success', 'Vendor created successfully');
    }

    public function show(Vendor $vendor): View
    {
        $this->authorize('view', $vendor);
        $vendor->load('purchaseOrders', 'invoices', 'contracts');

        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor): View
    {
        $this->authorize('update', $vendor);

        return view('vendors.edit', compact('vendor'));
    }

    public function update(StoreVendorRequest $request, Vendor $vendor): RedirectResponse
    {
        $this->authorize('update', $vendor);

        $vendor->update($request->validated());

        return redirect()->route('app.vendors.show', $vendor)
            ->with('success', 'Vendor updated successfully');
    }

    public function approve(Vendor $vendor): RedirectResponse
    {
        $this->authorize('approve', $vendor);

        $vendor->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Vendor approved');
    }
}
