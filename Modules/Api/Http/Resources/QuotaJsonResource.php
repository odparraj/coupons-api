<?php


namespace Modules\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class QuotaJsonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'amount_enabled'=> $this->amount_enabled,
            'amount_available'=> $this->amount_available,
            'is_active' => $this->is_active
        ];
    }

}