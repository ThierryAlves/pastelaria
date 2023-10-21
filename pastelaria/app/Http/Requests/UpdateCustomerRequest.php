<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'nome' => 'sometimes|min:8|max:80',
            'email' => 'sometimes|email|unique:App\Models\Customer,email',
            'telefone' => 'sometimes|min:8|max:11',
            'data_nascimento' => 'sometimes|date_format:d/m/Y',
            'endereco' => 'sometimes|min:10|max:100',
            'complemento' => 'sometimes|min:4|max:80',
            'bairro' => 'sometimes|min:10|max:100',
            'cep' => 'sometimes|min:8|max:8'
        ];
    }
}
