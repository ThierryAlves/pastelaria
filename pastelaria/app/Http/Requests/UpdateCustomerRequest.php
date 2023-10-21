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
            'nome' => ['sometimes'],
            'email' => ['sometimes', "unique:App\Models\Customer,{$this->id}"],
            'telefone' => ['sometimes'],
            'data_nascimento' => ['sometimes'],
            'endereco' => ['sometimes'],
            'complemento' => ['sometimes'],
            'bairro' => ['sometimes'],
            'cep' => ['sometimes']
        ]);
    }
}
