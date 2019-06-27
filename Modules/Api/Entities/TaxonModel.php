<?php


namespace Modules\Api\Entities;


use EloquentFilter\Filterable;
use Vanilo\Category\Models\Taxon;

class TaxonModel extends Taxon
{
    use Filterable;
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //Para sobre escribir la clave del id que utiliza laravel para hacer el route-model-binding (https://scotch.io/tutorials/cleaner-laravel-controllers-with-route-model-binding)
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    //Para el filtrado
    public function modelFilter($filter = null)
    {
        if ($filter === null) {
            $classModel = class_basename($this);
            $dirModels = join('', explode($classModel, get_class($this)));
            $filter = str_replace('\\Entities\\', '\\Filters\\', $dirModels) . str_replace('Model', 'Filter', $classModel);
        }

        return $filter;
    }

    public function products()
    {
        return $this->morphedByMany(
            ProductModel::class, 'model', 'model_taxons', 'taxon_id', 'model_id'
        );
    }

}