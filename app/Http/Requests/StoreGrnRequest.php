<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreGrnRequest extends FormRequest
{
    public function authorize(): bool { return Auth::user()->can('create_grns'); }

    public function rules(): array
    {
        return [
            'purchase_order_id'                  => ['required', 'uuid', 'exists:purchase_orders,id'],
            'notes'                              => ['nullable', 'string'],
            'delivery_note'                      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'items'                              => ['required', 'array', 'min:1'],
            'items.*.purchase_order_item_id'     => ['required', 'uuid', 'exists:purchase_order_items,id'],
            'items.*.description'                => ['required', 'string', 'max:500'],
            'items.*.quantity_ordered'           => ['required', 'numeric', 'min:0'],
            'items.*.quantity_received'          => ['required', 'numeric', 'min:0'],
            'items.*.unit_of_measure'            => ['required', 'string', 'max:50'],
        ];
    }
}
