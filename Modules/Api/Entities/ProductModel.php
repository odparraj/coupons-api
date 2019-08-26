<?php


namespace Modules\Api\Entities;


use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Vanilo\Category\Models\TaxonProxy;
use Vanilo\Contracts\Buyable;
use Vanilo\Product\Models\Product;
use Vanilo\Support\Traits\BuyableImageSpatieV7;
use Vanilo\Support\Traits\BuyableModel;
use Wildside\Userstamps\Userstamps;

class ProductModel extends Product implements Buyable, HasMedia
{
    use BuyableModel; // Implements Buyable methods for common Eloquent models
    use BuyableImageSpatieV7; // Implements Buyable's image methods using Spatie Media Library
    use HasMediaTrait; // Spatie package's default trait
    use SoftDeletes;
    use Filterable;
    use Userstamps;

    protected $fillable= [
        'uuid','name','sku','description','price','type','parent_id', 'discount'
    ];
    protected $primaryKey = 'id';
    protected $with= [
        'parent', 'user'
    ];

    protected $casts = [
        'discount' => 'array'
    ];

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

    public function morphTypeName():string{
        return static::class;
    }

    public function parent()
    {
        return $this->belongsTo(ProductModel::class,'parent_id','id');
    }

    public  function user()
    {
        return $this->belongsTo(UserModel::class,'created_by', 'id');
    }

    public function taxons()
    {
        return $this->morphToMany(
            TaxonProxy::modelClass(), 'model', 'model_taxons', 'model_id', 'taxon_id'
        );
    }
}