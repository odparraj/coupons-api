<?php

namespace Modules\Api\Transformers;

use Modules\Base\Transformers\BaseTransformer;
use Modules\Api\Entities\PermissionModel;

class PermissionTransformer extends BaseTransformer
{
    public function transform(PermissionModel $model)
    {
        return array_merge(
            $this->id($model),
            $this->name($model)
        );
    }

    private function id(PermissionModel $model)
    {
        return $this->__getGeneric($model, 'id', 'uuid');
    }

    private function name(PermissionModel $model)
    {
        return $this->__getGeneric($model, 'name');
    }
}