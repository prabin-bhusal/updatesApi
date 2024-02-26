<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment' => $this->comment,
            'parentId' => $this->parent_id,
            'newsId' => $this->news_id,
            'userId' => $this->user_id,
            'news' => new NewsResource($this->whenLoaded('news')),
            'user' => new UserResource($this->whenLoaded('user')),
            'replies' => $this->whenLoaded('replies', function () {
                return CommentResource::collection($this->replies);
            }),
        ];
    }
}
