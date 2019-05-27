<?php


namespace Modules\Api\Filters;


use Modules\Base\Filters\BaseFilter;

class TaxonFilter extends BaseFilter
{
    public $relations = [];

    protected $arrFieldsSearch = ['id', 'name'];

}