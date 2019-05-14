<?php

namespace Modules\Api\Repositories;

use Modules\Base\Repositories\aResourceRepository;
use Modules\Api\Entities\PermissionModel;
use Modules\Api\Http\Resources\PermissionJsonResource;

class PermissionRepository extends aResourceRepository
{
    protected $model = PermissionModel::class;
    protected $jsonResource = PermissionJsonResource::class;
}