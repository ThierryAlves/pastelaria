<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends OrderRequest
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
            'cliente_id' => ['required'],
            'produtos.*' => ['required']
        ]);
    }
}
