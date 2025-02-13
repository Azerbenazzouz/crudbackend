<?php

namespace App\Http\Controllers;

use App\Service\Impl\GeminiService;
use Illuminate\Http\Request;

class GeminiController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');

        if (!$prompt) {
            return response()->json(['error' => 'Prompt is required'], 400);
        }

        $content = $this->geminiService->generateContent($prompt);

        return response()->json(['content' => $content]);
    }
}
