<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
            'nome' => 'required|min:8|max:80',
            'email' => 'required|email|unique:App\Models\Customer,email',
            'telefone' => 'required|min:8|max:11',
            'data_nascimento' => 'required|date_format:d/m/Y',
            'endereco' => 'required|min:10|max:100',
            'complemento' => 'required|min:4|max:80',
            'bairro' => 'required|min:10|max:100',
            'cep' => 'required|min:8|max:8'
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->all();

        if ($this->has('telefone')) {
            $input['telefone'] = str_replace(['(',')',' ','-'], '', $this->get('telefone'));
        }
        if ($this->has('cep')) {
            $input['cep'] = str_replace('-', '', $this->get('cep'));
        }

        $this->replace($input);
    }

}
