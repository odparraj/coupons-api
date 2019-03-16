<?php

namespace Modules\Api\Repositories;

use Modules\Api\Entities\PermissionModel;
use Modules\Base\Repositories\RepositoryAbstract;
use Modules\Api\Entities\RoleModel;
use Modules\Api\Transformers\RoleTransformer;

class RoleRepository extends RepositoryAbstract
{
    protected $model = RoleModel::class;
    protected $transformer = RoleTransformer::class;

    public function syncPermissions($uuid,$permissions)
    {
        $resource = $this->getModel()
            ->whereUuid($uuid)
            ->first();

        if ($resource instanceof $this->model) {
            return $this->manager->createData(
                new Item(
                    $resource,
                    $this->getTransformer()
                )
            )->toArray();
        }

        return abort(404);
        return PermissionModel::whereIn('uuid',$uuids)->get();
    }


}