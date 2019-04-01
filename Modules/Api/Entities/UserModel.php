<?php

namespace Modules\Api\Entities;

use Modules\Base\Entities\BaseAuthenticatableModel;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

class UserModel extends BaseAuthenticatableModel
{
    use HasRoles;

    protected function getStoredRole($role)
    {
        $roleClass = $this->getRoleClass();

        if (is_numeric($role)) {
            return $roleClass->findById($role, $this->getDefaultGuardName());
        }

        if (is_string($role)) {
            if(Uuid::isValid($role)){
                return $roleClass->findByUuid($role, $this->getDefaultGuardName());
            }else{
                return $roleClass->findByName($role, $this->getDefaultGuardName());
            }
        }

        return $role;
    }
}
