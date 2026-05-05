<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovePurchaseRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('approve', $this->purchase_request);
    }

    public function rules(): array
    {
        return [
            'comments' => 'nullable|string',
        ];
    }
}
