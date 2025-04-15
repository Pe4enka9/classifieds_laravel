<?php

namespace App\Http\Resources;

use App\Models\Classified;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Classified
 */
class ClassifiedResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'image_url' => $this->image_url,
            'user' => new UserResource($this->user),
        ];
    }
}
