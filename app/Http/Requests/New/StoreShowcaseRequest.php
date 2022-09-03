<?php

namespace App\Http\Requests\New;

use Illuminate\Foundation\Http\FormRequest;

class StoreShowcaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:2|max:2000|nullable',
            'image' => 'image|mimes:jpg,png,jpeg|max:1048|nullable',
            'token' => 'required'
        ];
    }
}
