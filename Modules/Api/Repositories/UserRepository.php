<?php

namespace Modules\Api\Repositories;

use Modules\Base\Repositories\RepositoryAbstract;
use Modules\Api\Entities\UserModel;
use Modules\Api\Transformers\UserTransformer;

class UserRepository extends RepositoryAbstract
{
    protected $model = UserModel::class;
    protected $transformer = UserTransformer::class;
}


