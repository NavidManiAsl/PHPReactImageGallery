<?php

namespace App\Http\Requests;

use App\Rules\Serialized;
use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'image' => ['required', 'image','mimes:jpeg,png,jpg' ],
            'name' => ['required', 'string', 'max:50', 'unique:images'],
            'description' => ['string','max:2000'],
            'tags' => ['string','max:2000', new Serialized]

        ];
    }
}
