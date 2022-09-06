<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public static $wrap = null;
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'description'=> $this->description,
            'created_at' => $this->created_at,
            'image' => $this->image,
            'category' => $this->load('category')
        ];
    }
}
