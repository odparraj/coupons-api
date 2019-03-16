<?php

namespace Modules\Api\Transformers;

use Modules\Base\Transformers\BaseTransformer;
use Modules\Api\Entities\RoleModel;

class RoleTransformer extends BaseTransformer
{
    public function transform(RoleModel $model)
    {
        return array_merge(
            $this->id($model),
            $this->name($model)
        );
    }

    private function id(RoleModel $model)
    {
        return $this->__getGeneric($model, 'id', 'uuid');
    }

    private function name(RoleModel $model)
    {
        return $this->__getGeneric($model, 'name');
    }
}