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

    public final function products()
    {
        return $this->hasMany(ProductModel::class, 'created_by', 'id');
    }

    public final function customers()
    {
        return $this->hasMany(UserModel::class, 'created_by', 'id');
    }

    public function assignQuota($amountEnabled=0)
    {
        if($this->hasRole('customer')){
            $this->quota()->create([
                'amount_enabled' => $amountEnabled,
            ]);
        }
    }

    public function quota()
    {
        return $this->hasOne(QuotaModel::class,'user_id','id');
    }
}
