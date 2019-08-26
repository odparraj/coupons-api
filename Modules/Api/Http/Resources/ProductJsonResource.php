<?php


namespace Modules\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'description'=> $this->description,
            'price'=> $this->price,
            'sku'=> $this->sku,
            'type'=> $this->type,
            'parent_id'=> $this->when($this->resource->parent, $this->parent->uuid ?? null),
            'user' => $this->when($this->resource->user, $this->user->name),
            'imege'=> $this->getFirstMediaUrl(),
            'discount'=> $this->discount
        ];
    }
}