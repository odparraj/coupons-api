<?php

namespace Modules\Api\Entities;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;
use Wildside\Userstamps\Userstamps;

class RoleModel extends Role
{
    use SoftDeletes, Filterable, Userstamps;

    protected $primaryKey = 'id';

    protected $fillable= [ 'name','guard_name','uuid' ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //Para sobre escribir la clave del id que utiliza laravel para hacer el route-model-binding (https://scotch.io/tutorials/cleaner-laravel-controllers-with-route-model-binding)
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    //Para el filtrado
    public function modelFilter($filter = null)
    {
        if ($filter === null) {
            $classModel = class_basename($this);
            $dirModels = join('', explode($classModel, get_class($this)));
            $filter = str_replace('\\Entities\\', '\\Filters\\', $dirModels) . str_replace('Model', 'Filter', $classModel);
        }

        return $filter;
    }

    /**
     * @param string|array|\Spatie\Permission\Contracts\Permission|\Illuminate\Support\Collection $permissions
     *
     * @return \Spatie\Permission\Contracts\Permission|\Spatie\Permission\Contracts\Permission[]|\Illuminate\Support\Collection
     */
    protected function getStoredPermission($permissions)
    {
        $permissionClass = $this->getPermissionClass();

        if (is_numeric($permissions)) {
            return $permissionClass->findById($permissions, $this->getDefaultGuardName());
        }

        if (is_string($permissions)) {
            if(Uuid::isValid($permissions)){
                return $permissionClass->findByUuid($permissions, $this->getDefaultGuardName());
            }else{
                return $permissionClass->findByName($permissions, $this->getDefaultGuardName());
            }
        }

        if (is_array($permissions)) {
            return $permissionClass
                ->whereIn('name', $permissions)
                ->whereIn('guard_name', $this->getGuardNames())
                ->get();
        }

        return $permissions;
    }

    public static function findByUuid(string $uuid, $guardName = null)
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('uuid', $uuid)->where('guard_name', $guardName)->first();

        if (! $role) {
            throw RoleDoesNotExist::withId($uuid);
        }

        return $role;
    }

}
