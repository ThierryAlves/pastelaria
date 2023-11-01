<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente' => ['exists:App\Models\Customer,id'],
            'produtos' => ['required','array'],
            'produtos.*' => ['exists:App\Models\Product,id']
        ];
    }

    public function messages()
    {
        return [
            'produtos.*.exists' => 'The product :input don\'t exists.'
        ];
    }
}
