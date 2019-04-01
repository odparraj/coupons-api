<?php

namespace Modules\Api\Entities;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Models\Permission;

class PermissionModel extends Permission
{
    use SoftDeletes, Filterable, Userstamps;

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'guard_name', 'uuid'];

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

    public static function findByUuid(string $uuid, $guardName = null)
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $permission = static::getPermissions(['uuid' => $uuid, 'guard_name' => $guardName])->first();
        if (! $permission) {
            throw PermissionDoesNotExist::create($uuid, $guardName);
        }

        return $permission;
    }

}
