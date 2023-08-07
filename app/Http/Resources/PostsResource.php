<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'post_title'=>$this->post_title,
            'post_body'=>$this->post_body,
            'post_image'=>$this->post_image,
            'user_id'=>$this->user_id,
            'category_id'=>$this->category_id,
        ];
    }
}
