<?php

namespace Modules\Api\Transformers;

use Modules\Base\Transformers\BaseTransformer;
use Modules\Api\Entities\UserModel;

class UserTransformer extends BaseTransformer
{

    public function transform(UserModel $model)
    {
        return array_merge(
            $this->id($model),
            $this->name($model),
            $this->email($model)
        );
    }

    private function id(UserModel $model)
    {
        return $this->__getGeneric($model, 'id', 'uuid');
    }

    private function name(UserModel $model)
    {
        return $this->__getGeneric($model, 'name');
    }

    private function email(UserModel $model)
    {
        return $this->__getGeneric($model, 'email');
    }
}