<?php

namespace App\Http\Requests;


class UpdateProductRequest extends ProductRequest
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
        return array_merge_recursive(parent::rules(), [
            'nome' => ['sometimes'],
            'preco' => ['sometimes'],
            'foto_produto' => ['sometimes']
        ]);
    }
}
