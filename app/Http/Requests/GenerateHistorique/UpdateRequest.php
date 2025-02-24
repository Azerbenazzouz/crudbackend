<?php

namespace App\Http\Requests\GenerateHistorique;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{

    public function authorize(): bool {
        return true;
    }

    public function rules(): array
    {
        return [
            'prompt' => 'string',
            'response' => 'string',
            'response' => 'string',
        ];
    }
}
