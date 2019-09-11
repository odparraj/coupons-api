<?php

namespace Modules\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderJsonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'number' => $this->number,
            'status' => $this->status,
            'address' => $this->notes,
            'date' => $this->created_at,
            //'items' => $this->items
        ];   
    }
}