<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'resourceFile' => env('APP_URL') . '/public/files/' . $this->resource_file,
            'userId' => $this->user_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
