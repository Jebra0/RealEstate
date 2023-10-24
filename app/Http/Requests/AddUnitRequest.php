<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUnitRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //features
            'air' => 'boolean',
            'heat' => 'boolean',
            'bedroom' => 'int|max:20|required',
            'living_room' => 'int|max:20|required',
            'bathroom' => 'int|max:20|required',
            'kitchen' => 'int|max:20|required',

            //parent_unit
            'floor' => 'int|max:250|required',
            'units' => 'int|max:500|required',
            'Property' => 'string|max:500|required', // property name
            'state' => 'string|max:500|required',
            'street' => 'string|max:500|required',
            'city' => 'string|max:500|required',
            'elevator' => 'boolean',

            //unit
            'description' => 'string|max:250|required',
            'price' => 'int|max:11|required',
            'type' => 'string|max:15|required',
            'for' => 'string|max:15|required',

            //image
            'image.*' => 'image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
