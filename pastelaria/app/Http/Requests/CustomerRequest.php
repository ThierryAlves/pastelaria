<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['min:8', 'max:80'],
            'email' => ['email'],
            'telefone' => ['min:8', 'max:11'],
            'data_nascimento' => ['date_format:d/m/Y'],
            'endereco' => ['min:10', 'max:100'],
            'complemento' => ['min:4', 'max:80'],
            'bairro' => ['min:10', 'max:100'],
            'cep' => ['min:8', 'max:8']
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
