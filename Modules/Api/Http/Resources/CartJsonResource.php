<?php


namespace Modules\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CartJsonResource extends JsonResource
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
            'state' => $this->getOriginal('state'),
            'total'=> $this->total(),
            'count'=> $this->itemCount(),
            'items' => CartItemJsonResource::collection($this->whenLoaded('items'))
        ];
    }

}