<?php

namespace App\Http\Requests\GenerateHistorique;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{

    public function authorize(): bool {
        return true;
    }

    public function rules(): array
    {
        return [
            'prompt' => 'required|string',
            'response' => 'required|string',
            'response' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id'
        ];
    }
}
