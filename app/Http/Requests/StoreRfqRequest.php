<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRfqRequest extends FormRequest
{
    public function authorize(): bool { return Auth::user()->can('create_rfqs'); }

    public function rules(): array
    {
        return [
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['nullable', 'string'],
            'deadline'            => ['required', 'date', 'after:today'],
            'purchase_request_id' => ['nullable', 'uuid', 'exists:purchase_requests,id'],
            'vendor_ids'          => ['required', 'array', 'min:1'],
            'vendor_ids.*'        => ['uuid', 'exists:vendors,id'],
        ];
    }
}
