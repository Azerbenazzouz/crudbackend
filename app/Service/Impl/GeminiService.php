<?php

namespace App\Service\Impl;

use Gemini;
use Gemini\Data\Blob;
use Gemini\Data\Content;

class GeminiService {
    protected $client;

    public function __construct() {
        $this->client = Gemini::client(config('app.GEMINI_API_KEY'));
    }

    public function generateContent(string|Blob|array|Content $prompt) : string{
        $response = $this->client->geminiPro()->generateContent($prompt);
        return $response->text();
    }

}
