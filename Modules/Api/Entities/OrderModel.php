<?php

namespace Modules\Api\Entities;

use Vanilo\Order\Models\Order;
use EloquentFilter\Filterable;

class OrderModel extends Order
{
    protected $table = 'orders';
    use Filterable;
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
}