<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Product\DeleteMultipleRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Requests\Product\DeleteRequest;
use App\Http\Resources\ProductResource;
use App\Service\Interfaces\ProductServiceInterface as ProductService;

class ProductController extends BaseController {

    protected $productService;
    protected $resource = ProductResource::class;
    public function __construct(
        ProductService $productService
    ) {
        parent::__construct($productService);
    }

    protected function getStoreRequest(): string {
        return StoreRequest::class;
    }

    protected function getUpdateRequest(): string {
        return UpdateRequest::class;
    }

    protected function getDeleteRequest(): string {
        return DeleteRequest::class;
    }

    protected function getDeleteMultipleRequest(): string {
        return DeleteMultipleRequest::class;
    }

}
