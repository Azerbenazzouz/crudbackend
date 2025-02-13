<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateRequest;
use App\Http\Resources\ApiResource;
use App\Service\Impl\GenerateService;
use Illuminate\Http\Request;

class GenerateController extends Controller
{
    protected $generateService;

    public function __construct(GenerateService $generateService)
    {
        $this->generateService = $generateService;
    }

    public function generateContent(Request $request) {
        $prompt = $request->input('prompt');
        if (!$prompt) {
            return ApiResource::error([],'Prompt is required', 400);
        }
        $content = $this->generateService->generateContent($prompt);
        return ApiResource::ok(['content' => $content]);
    }

    public function generateSocialMediaPostDescription(GenerateRequest $request){
        $content = $this->generateService->generateSocialMediaPostDescription($request);
        return ApiResource::ok(['content' => $content]);
    }

    public function generateProductSEOContent(GenerateRequest $request){
        $content = $this->generateService->generateProductSEOContent($request);
        return ApiResource::ok(['content' => $content]);
    }

    public function generateProductDescription(GenerateRequest $request){
        $content = $this->generateService->generateProductDescription($request);
        return ApiResource::ok(['content' => $content]);
    }
}
