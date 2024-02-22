<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'attachedFile' => env('APP_URL') . '/storage/files/' . $this->attached_file,
            'banner' => env('APP_URL') . '/storage/images/' . $this->banner,
            'date' => $this->date,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
