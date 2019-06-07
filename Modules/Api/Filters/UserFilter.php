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

    protected $arrFieldsSearch = ['id', 'name', 'username', 'created_by'];

    public function createdBy($id)
    {
        return $this->where('created_by',$id);
    }
}

