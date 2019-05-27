<?php


namespace Modules\Api\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class TaxonJsonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=> $this->uuid,
            'name'=> $this->name,
            'slug'=> $this->slug,
            'parent_id' => $this->parent?$this->parent->uuid:null,
            'taxonomy_id'=> $this->taxonomy->uuid
        ];
    }
}