<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest {

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
}
