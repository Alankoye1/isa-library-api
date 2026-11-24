<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'year' => $this->year,
            'user_id' => $this->user_id,
            'owner' => $this->user?->name,
            'created_at' => $this->created_at,
        ];
    }
}
