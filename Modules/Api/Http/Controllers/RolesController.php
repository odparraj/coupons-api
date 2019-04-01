<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Api\Entities\RoleModel;
use Modules\Api\Repositories\RoleRepository;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Http\Resources\Json\JsonResource;

class RolesController extends BaseController
{
    protected $uuidToId = [
        //'product_type_id'=> \Modules\CoreBanking\Entities\ProductTypeModel::class,
        //'company_id'=> \Modules\CoreBanking\Entities\CompanyModel::class,
    ];

    protected $arrValidate = [
        'name' => 'required|string|max:255'
    ];

    public function __construct(RoleRepository $repository)
    {
        parent::__construct($repository);
    }

    public function syncPermissions(Request $request, RoleModel $role)
    {
        $permissionsTableName = config('permission.table_names.permissions');

        $request->validate([
            '*.id' => "required|exists:{$permissionsTableName},uuid"
        ]);

        // No es necesario limpiar la data porque la funcion SyncPermissions de la librería de roles y permisos
        // lo contempla, al final la data de entrada se filtra para obtener instancias validas del modelo Permission
        $role->syncPermissions($request->all());

        return JsonResponse::collection($role->permissions);
    }

    public function rolePermissions(Request $request, RoleModel $role)
    {
        return JsonResponse::collection($role->permissions);
    }

}

// Ojo adaptar a la logica del repositorio
class JsonResponse extends JsonResource
{
    public function toArray($request)
    {
        return [

            'id'=> $this->uuid,
            'name'=> $this->name
        ];
    }
}
