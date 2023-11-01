<?php

namespace App\Http\Requests;

use Cassandra\Custom;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends CustomerRequest
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
            'placeholder' => ['required_without_all:nome,email,telefone,data_nascimento,endereco,complemento,bairro,cep'],
            'nome' => ['sometimes'],
            'email' => ['sometimes', "unique:App\Models\Customer,email"],
            'telefone' => ['sometimes'],
            'data_nascimento' => ['sometimes'],
            'endereco' => ['sometimes'],
            'complemento' => ['sometimes'],
            'bairro' => ['sometimes'],
            'cep' => ['sometimes']
        ]);
    }

    public function messages()
    {
        return [
            'required_without_all' => 'nome,email,telefone,data_nascimento,endereco,complemento,bairro or cep must be present.'
        ];
    }
}
