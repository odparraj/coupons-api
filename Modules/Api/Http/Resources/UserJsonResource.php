<?php

namespace Modules\Api\Http\Resources;

use Modules\Base\Http\Resources\BaseJsonResource;

class UserJsonResource extends BaseJsonResource
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
            'email' => $this->email,
        ];
    }
}
