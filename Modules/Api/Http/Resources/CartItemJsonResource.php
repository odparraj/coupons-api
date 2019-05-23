<?php


namespace Modules\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CartItemJsonResource extends JsonResource
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
            'product_type'=> $this->product_type,
            'product'=> new ProductJsonResource($this->whenLoaded('product')),
            'quantity'=> $this->quantity,
            'price'=> $this->price,
            'total'=> $this->total

        ];
    }
}