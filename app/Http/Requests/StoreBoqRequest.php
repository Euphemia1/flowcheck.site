<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBoqRequest extends FormRequest
{
    public function authorize(): bool { return Auth::user()->can('create_boqs') || Auth::user()->can('update_boqs'); }

    public function rules(): array
    {
        return [
            'title'                  => ['required', 'string', 'max:255'],
            'description'            => ['nullable', 'string'],
            'tender_id'              => ['nullable', 'uuid', 'exists:tenders,id'],
            'items'                  => ['required', 'array', 'min:1'],
            'items.*.description'    => ['required', 'string', 'max:500'],
            'items.*.unit_of_measure'=> ['required', 'string', 'max:50'],
            'items.*.quantity'       => ['required', 'numeric', 'min:0.01'],
            'items.*.unit_rate'      => ['required', 'numeric', 'min:0'],
            'items.*.category'       => ['nullable', 'string', 'max:100'],
        ];
    }
}
