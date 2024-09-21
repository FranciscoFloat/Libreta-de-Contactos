<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'birthday' => 'nullable|date',
            'website' => 'nullable|url',
            'company' => 'nullable|string|max:255',
            'phoneNumbers' => 'array',
            'phoneNumbers.*.number' => 'required|string',
            'phoneNumbers.*.type' => 'nullable|string',
            'emails' => 'array',
            'emails.*.email' => 'required|email',
            'addresses' => 'array',
            'addresses.*.street' => 'required|string',
            'addresses.*.city' => 'required|string',
            'addresses.*.state' => 'required|string',
            'addresses.*.zipCode' => 'required|string',
        ];
    }
}
