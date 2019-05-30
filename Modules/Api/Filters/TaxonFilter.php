<?php


namespace Modules\Api\Filters;


use Modules\Base\Filters\BaseFilter;

class TaxonFilter extends BaseFilter
{
    public $relations = [];

    protected $arrFieldsSearch = ['id', 'name', 'parent_id', 'taxonomy_id'];

    public function parent($uuid)
    {
        if($uuid=='null'){
            return $this->whereNull('parent_id');
        }else{
            return $this->related('parent','uuid', '=', $uuid);
        }
    }

    public function taxonomy($uuid)
    {
        return $this->related('taxonomy','uuid', '=', $uuid);
    }

}