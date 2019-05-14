<?php

namespace Modules\Api\Repositories;

use Modules\Base\Repositories\aResourceRepository;
use Modules\Api\Entities\RoleModel;
use Modules\Api\Http\Resources\RoleJsonResource;

class RoleRepository extends aResourceRepository
{
    protected $model = RoleModel::class;
    protected $jsonResource = RoleJsonResource::class;

    public function syncPermissions($uuid, $permissions)
    {
        $insModel = $this->getModel()
            ->whereUuid($uuid)
            ->first();

        if ($insModel instanceof $this->model) {
            $class = $this->getBaseJsonResource();
            $jsonResource = new $class($insModel);
            
            return ResponseBuilder::success($jsonResource);
        }

        return abort(404);
    }
}