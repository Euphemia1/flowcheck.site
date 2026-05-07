<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreContractRequest extends FormRequest
{
    public function authorize(): bool { return Auth::user()->can('create_contracts'); }

    public function rules(): array
    {
        return [
            'vendor_id'  => ['required', 'uuid', 'exists:vendors,id'],
            'title'      => ['required', 'string', 'max:255'],
            'type'       => ['nullable', 'in:fixed_price,rate_contract,framework'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after:start_date'],
            'value'      => ['nullable', 'numeric', 'min:0'],
            'document'   => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
        ];
    }
}
