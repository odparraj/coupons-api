<?php

namespace Modules\Api\Repositories;

use Modules\Base\Repositories\RepositoryAbstract;
use Modules\Api\Entities\PermissionModel;
use Modules\Api\Transformers\PermissionTransformer;

class PermissionRepository extends RepositoryAbstract
{
    protected $model = PermissionModel::class;
    protected $transformer = PermissionTransformer::class;
}