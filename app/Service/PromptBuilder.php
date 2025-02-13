<?php

namespace App\Service;

use App\Models\Product;

class PromptBuilder {
    public function buildSocialMediaPostPrompt(Product $product, string $additionalInformation = ''): array {
        return [
            'Product Name: ' . $product->name,
            'Product Description: ' . $product->description,
            'Product Price: ' . $product->price,
            'Additional Information: ' . $additionalInformation,
            'objectives: Generate a social media post description for the product',
        ];
    }

    public function buildProductSEOContentPrompt(Product $product, string $additionalInformation = ''): array {
        return [
            'Product Name: ' . $product->name,
            'Product Description: ' . $product->description,
            'Product Price: ' . $product->price,
            'Additional Information: ' . $additionalInformation,
            'objectives: Generate SEO content for the product',
        ];
    }

    public function buildProductDescription(Product $product, string $additionalInformation = ''): array {
        return [
            'Product Name: ' . $product->name,
            'Product Description: ' . $product->description,
            'Product Price: ' . $product->price,
            'Additional Information: ' . $additionalInformation,
            'objectives: Generate a product description',
        ];
    }
}
