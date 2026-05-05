<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Invoice::class);
    }

    public function rules(): array
    {
        return [
            'vendor_id' => 'required|uuid|exists:vendors,id',
            'purchase_order_id' => 'nullable|uuid|exists:purchase_orders,id',
            'invoice_number' => 'required|string|max:70',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'total_amount' => 'required|numeric|min:0.01',
            'file' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:10240',
        ];
    }
}
