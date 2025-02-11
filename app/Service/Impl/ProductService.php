<?php
namespace App\Service\Impl;

use App\Repositories\ProductRepository;
use App\Service\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductService extends BaseService implements ProductServiceInterface{

    protected $productRepo;
    protected $payload;

    public function __construct(
        ProductRepository $productRepo
    ) {
        parent::__construct($productRepo);
    }

    protected function requestPayload(): array {
        return ['name', 'slug', 'description', 'price', 'image', 'user_id'];
    }

    protected function getSearchField(): array {
        return ['name', 'slug', 'description'];
    }

    protected function getPerpage() : int {
        return 20;
    }

    protected function getSimpleFilter() : array {
        return ['name', 'slug'];
    }

    protected function getComplexFilter(): array{
        return ['id', 'price', 'user_id'];
    }

    protected function getDateFilter(): array {
        return ['created_at'];
    }

    protected function processPayload(?Request $request = null) {
        return $this
            ->generateSlug($this->payload['name'] ?? '');
    }

    protected function generateSlug($name) {
        if (empty($name)) {
            return $this;
        }
        $this->payload['slug'] = Str::slug($name);
        return $this;
    }

}
