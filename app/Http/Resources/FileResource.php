<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'size_in_bytes' => $this->size_in_bytes,
            'mime_type' => $this->mime_type,
            'url' => $this->url,
            'created_at' => $this->created_at,
        ];
    }
}
