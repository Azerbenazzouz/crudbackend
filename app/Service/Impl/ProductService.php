<?php
namespace App\Service\Impl;

use App\Repositories\ProductRepository;
use App\Service\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            ->generateSlug($this->payload['name'] ?? '')
            ->setUserId($request)
            ->uploadImage($request);

    }

    protected function generateSlug($name) {
        if (empty($name)) {
            return $this;
        }
        $this->payload['slug'] = Str::slug($name);
        return $this;
    }

    protected function uploadImage(Request $request) {
        if($request->hasFile('image')) {
            // upload image
            // $image = $request->file('image')->store('products', 'public');
            // $image = Storage::disk('public')->put('products', $request->file('image'));
            $image = Storage::disk('public')->putFileAs('products',
                $request->file('image'),
                Str::uuid().'.'.$request->file('image')->extension()
            );
        }
        $this->payload['image'] = $image ?? '';
        return $this;
    }

}
