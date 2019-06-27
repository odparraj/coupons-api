<?php


namespace Modules\Api\Filters;


use Illuminate\Support\Facades\DB;
use Modules\Base\Filters\BaseFilter;

class ProductFilter extends BaseFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    protected $arrFieldsSearch = [
        'id', 'name', 'created_by',
        'type', 'parent_id', 'min_price', 'max_price', 'taxons'
    ];

    public function createdBy($id)
    {
        return $this->where('created_by',$id);
    }

    public function type($type)
    {
        return $this->where('type',$type);
    }

    public function minPrice($price)
    {
        return $this->where('price','>=', $price);
    }

    public function maxPrice($price)
    {
        return $this->where('price','<=', $price);
    }

    public function taxons($taxons)
    {
        return $this->related('taxons', function($query) use ($taxons) {
            return $query->whereIn('uuid', $taxons);
        });
    }

    public function parent($uuid)
    {
        return $this->related('parent', 'uuid', '=', $uuid);
    }
}