<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address' => 'required|array',
            'address.address_id' => 'required|integer|exists:addresses,id',
            'address.country' => 'required|string|max:255',
            'address.street' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.description' => 'nullable|string',

            'car' => 'required|array',
            'car.car_id' => 'required|integer|exists:cars,id',
            'car.category' => 'required|string|max:255',
            'car.brand' => 'required|string|max:255',
            'car.name' => 'required|string|max:255',
            'car.color' => 'required|string|max:255',
            'car.description' => 'nullable|string',
            'car.miles' => 'required|numeric',
            'car.year' => 'required|integer',
            'car.price' => 'required|numeric', // Add validation for price if needed

            'pictures' => 'nullable|array',
            'pictures.*.id' => 'required|integer|exists:pictures,id', // Ensure picture IDs exist
            'pictures.*.Url' => 'required|url',
        ];
    }
}
