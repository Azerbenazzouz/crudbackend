<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenerateHistoriqueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'prompt' => $this->prompt,
            'additional' => $this->additional,
            'response' => $this->response,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
