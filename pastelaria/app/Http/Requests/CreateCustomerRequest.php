<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends CustomerRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge_recursive(parent::rules(), [
            'nome' => ['required'],
            'email' => ['required', "unique:App\Models\Customer"],
            'telefone' => ['required'],
            'data_nascimento' => ['required'],
            'endereco' => ['required'],
            'bairro' => ['required'],
            'cep' => ['required']
        ]);
    }

}
