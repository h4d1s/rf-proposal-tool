<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image_urls = [];
        if($this->images !== null) {
            $image_urls = $this->images->map(fn ($image) => asset('storage/images/' . $image->path));
        }

        return array_merge(parent::toArray($request), [
            'images' => $image_urls,
        ]);
    }
}
