<?php


namespace Modules\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class TransactionJsonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=> $this->uuid,
            'amount' => $this->amount,
            'amount_old' => $this->amount_old,
            'amount_new' => $this->amount_new,
            'operation' => New OperationTypeJsonResource($this->operationType),
            'created_at' => $this->created_at
        ];
    }
}