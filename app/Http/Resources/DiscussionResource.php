<?php

namespace App\Http\Resources;

use App\Models\Client;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $owner_name = "";
        if($this->discussionable instanceof Client) {
            $owner_name = $this->discussionable->full_name;
        } else {
            $owner_name = $this->discussionable->name;
        }

        return [
            'id' => $this->id,
            'body' => $this->body,
            'owner_type' => strtolower(class_basename($this->discussionable)),
            'owner_name' => $owner_name,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
