<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Vendor::class);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tax_pin' => 'nullable|string|max:50',
            'payment_terms' => 'nullable|string',
            'bank_details' => 'nullable|json',
        ];
    }
}
