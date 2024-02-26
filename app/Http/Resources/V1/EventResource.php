<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'venue' => $this->venue,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'user' => new UserResource($this->whenLoaded('user')),
            'bookedUsers' => new UserCollection($this->whenLoaded('users')),
        ];
    }
}
