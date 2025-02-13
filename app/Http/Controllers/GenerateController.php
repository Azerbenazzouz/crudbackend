<?php

namespace App\Http\Controllers;

use App\Service\Impl\GenerateService;
use Illuminate\Http\Request;

class GenerateController extends Controller
{
    protected $generateService;

    public function __construct(GenerateService $generateService)
    {
        $this->generateService = $generateService;
    }

    public function generateContent(Request $request)
    {
        $prompt = $request->input('prompt');

        if (!$prompt) {
            return response()->json(['error' => 'Prompt is required'], 400);
        }

        $content = $this->generateService->generateContent($prompt);

        return response()->json(['content' => $content]);
    }

    public function generateSocialMediaPostDescription(Request $request){
        $productId = $request->input('product_id');
        $request->input('additional_information', '');
        if (!$productId) {
            return response()->json(['error' => 'Product ID is required'], 400);
        }
        $content = $this->generateService->generateSocialMediaPostDescription($request);
        return response()->json(['content' => $content]);
    }

    public function generateProductSEOContent(Request $request){
        $productId = $request->input('product_id');
        $request->input('additional_information', '');
        if (!$productId) {
            return response()->json(['error' => 'Product ID is required'], 400);
        }
        $content = $this->generateService->generateProductSEOContent($request);
        return response()->json(['content' => $content]);
    }

    public function generateProductDescription(Request $request){
        $productId = $request->input('product_id');
        $request->input('additional_information', '');
        if (!$productId) {
            return response()->json(['error' => 'Product ID is required'], 400);
        }
        $content = $this->generateService->generateProductDescription($request);
        return response()->json(['content' => $content]);
    }
}
