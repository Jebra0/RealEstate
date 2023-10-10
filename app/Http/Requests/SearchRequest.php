<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
//            'for' => 'string',
//            'price' => 'string',
//            'type' => 'string',
//            'state' => 'max:250|string',
//            'city' => 'max:250|string',
//            'name' => 'max:250|string',
        ];
    }
}
