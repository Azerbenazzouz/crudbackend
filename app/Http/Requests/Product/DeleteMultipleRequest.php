<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use App\Repositories\ProductRepository;

class DeleteMultipleRequest extends BaseRequest {

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
            'ids' => 'required|array',
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $ids = $this->input('ids');
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    // dd($id);
                    if (!is_numeric($id)) {
                        $validator->errors()->add('product', 'product id must be numeric');
                    }
                    $product = $this->productRepository->findById($id);
                    if (!$product) {
                        $validator->errors()->add('product', 'product not found with id: '.$id);
                    }
                }
            }
        });
    }
}
