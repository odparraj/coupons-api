<?php

namespace Modules\Api\Filters;


use Modules\Base\Filters\BaseFilter;
//use Modules\Services\Models\ServiceModel;

class UserFilter extends BaseFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    protected $arrFieldsSearch = ['id', 'name', 'username'];

    /*public function service($uuid)
    {
         $service = ServiceModel::whereUuid($uuid)->first(['id']);

         $idService = is_null($service)? null : $service->id;

         $this->where('service_id', '=', $idService);

         return $this;
    }*/

    /*public function type($uuid)
    {
        $type = IncidentTypeModel::whereUuid($uuid)->first(['id']);

        $idType = is_null($type)? null : $type->id;

        $this->where('incident_type_id', '=', $idType);

        return $this;
    }*/
}

