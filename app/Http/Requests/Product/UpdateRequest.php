<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use App\Repositories\ProductRepository;

class UpdateRequest extends BaseRequest {

    private $productRepository;

    public function __construct() {
        $this->productRepository = app(ProductRepository::class);

    }
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|max:255|min:3',
            'description' => 'string',
            'price' => 'numeric',
            'image' => 'image',
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $product = $this->productRepository->findById($this->route('product'));
            if (!$product) {
                $validator->errors()->add('product', 'Product not found');
            }
        });
    }
}
