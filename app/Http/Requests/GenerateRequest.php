<?php
namespace App\Http\Requests;

class GenerateRequest extends BaseRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'additional_information' => 'string',
        ];
    }

}

