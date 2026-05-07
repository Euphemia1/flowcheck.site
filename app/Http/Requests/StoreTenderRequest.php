<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTenderRequest extends FormRequest
{
    public function authorize(): bool { return Auth::user()->can('create_tenders'); }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:255'],
            'type'             => ['required', 'string'],
            'publication_date' => ['required', 'date'],
            'closing_date'     => ['required', 'date', 'after:publication_date'],
            'boq_id'           => ['nullable', 'uuid', 'exists:boqs,id'],
        ];
    }
}
