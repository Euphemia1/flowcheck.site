<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\PurchaseRequest::class);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'justification' => 'nullable|string',
            'department_id' => 'required|uuid|exists:departments,id',
            'required_by_date' => 'required|date',
            'priority' => 'required|in:low,normal,high,urgent',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.unit_of_measure' => 'required|string',
            'items.*.quantity_requested' => 'required|numeric|min:0.01',
            'items.*.unit_price_estimated' => 'required|numeric|min:0',
            'items.*.category' => 'nullable|string',
        ];
    }
}
