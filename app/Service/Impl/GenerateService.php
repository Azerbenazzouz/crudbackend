<?php
namespace App\Service\Impl;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Service\PromptBuilder;

class GenerateService {

    protected $geminiService;
    protected $productRepository;
    protected $promptBuilder;

    public function __construct(GeminiService $geminiService, ProductRepository $productRepository, PromptBuilder $promptBuilder) {
        $this->geminiService = $geminiService;
        $this->productRepository = $productRepository;
        $this->promptBuilder = $promptBuilder;
    }

    public function generateContent(string $prompt): string {
        return $this->geminiService->generateContent($prompt);
    }

    // generate social media post description for product based on product name and description and product image and price and additonal information
    public function generateSocialMediaPostDescription(Request $request): string {
        $productId = $request->input('product_id');
        try {
            $product = $this->productRepository->findById($productId)->first();

            if (!$product) {
                return 'Product not found';
            }

            $additionalInformation = $request->input('additional_information', '');

            $prompt = $this->promptBuilder->buildSocialMediaPostPrompt($product, $additionalInformation);

            return $this->geminiService->generateContent($prompt);
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            return 'Error generating content: ' . $e->getMessage();
        }
    }

    // generate SEO content for product based on product name and description and product image and price and additonal information
    public function generateProductSEOContent(Request $request): string {
        $productId = $request->input('product_id');
        try {
            $product = $this->productRepository->findById($productId)->first();

            if (!$product) {
                return 'Product not found';
            }

            $additionalInformation = $request->input('additional_information', '');

            $prompt = $this->promptBuilder->buildProductSEOContentPrompt($product, $additionalInformation);

            return $this->geminiService->generateContent($prompt);
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            return 'Error generating content: ' . $e->getMessage();
        }
    }

    // generate product description based on product name and description and product image and price and additonal information
    public function generateProductDescription(Request $request): string {
        $productId = $request->input('product_id');
        try {
            $product = $this->productRepository->findById($productId)->first();

            if (!$product) {
                return 'Product not found';
            }

            $additionalInformation = $request->input('additional_information', '');

            $prompt = $this->promptBuilder->buildProductDescription($product, $additionalInformation);

            return $this->geminiService->generateContent($prompt);
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            return 'Error generating content: ' . $e->getMessage();
        }
    }
}
