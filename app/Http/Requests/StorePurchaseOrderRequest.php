<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePurchaseOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('create_purchase_orders');
    }

    public function rules(): array
    {
        return [
            'purchase_request_id'    => ['nullable', 'uuid', 'exists:purchase_requests,id'],
            'vendor_id'              => ['required', 'uuid', 'exists:vendors,id'],
            'delivery_address'       => ['required', 'string', 'max:500'],
            'expected_delivery_date' => ['required', 'date', 'after:today'],
            'payment_terms'          => ['nullable', 'string', 'max:100'],
            'items'                  => ['required', 'array', 'min:1'],
            'items.*.description'    => ['required', 'string', 'max:500'],
            'items.*.unit_of_measure'=> ['required', 'string', 'max:50'],
            'items.*.quantity'       => ['required', 'numeric', 'min:0.01'],
            'items.*.unit_price'     => ['required', 'numeric', 'min:0'],
        ];
    }
}
