<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'bannerImage' => env('APP_URL') . '/storage/images/' . $this->banner_image,
            'userId' => $this->user_id,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'comments' => new CommentCollection($this->whenLoaded('comments')),
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}

// TODO: comments fetch not working with news