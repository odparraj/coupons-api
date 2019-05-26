<?php


namespace Modules\Api\Http\Resources;


use Modules\Base\Http\Resources\UuidNameJsonResource;

class TaxonomyJsonResource extends UuidNameJsonResource
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
            'slug' => $this->slug,
        ];
    }
}