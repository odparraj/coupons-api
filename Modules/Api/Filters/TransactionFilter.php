<?php


namespace Modules\Api\Filters;


use Modules\Base\Filters\BaseFilter;

class TransactionFilter extends BaseFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    protected $arrFieldsSearch = ['id'];
}