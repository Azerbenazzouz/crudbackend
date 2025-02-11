<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use App\Repositories\ProductRepository;

class DeleteRequest extends BaseRequest {

    private $productRepository;

    public function __construct() {
        $this->productRepository = app(ProductRepository::class);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array {
        return [];
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
