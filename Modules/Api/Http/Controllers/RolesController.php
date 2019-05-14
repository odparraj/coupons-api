<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Support\Arr;
use Modules\Api\Entities\RoleModel;
use Modules\Api\Http\Middleware\RolesMiddleware;
use Modules\Api\Repositories\RoleRepository;
use Modules\Base\General\ResponseBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Middleware\iPermissibleMiddleware;
use Modules\Base\Http\Resources\UuidNameJsonResource;


class RolesController extends BaseController implements iPermissibleMiddleware
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
        $this->applyPermissibleMiddleware();
    }

    public function syncPermissions(Request $request, RoleModel $role)
    {
        $permissionsTableName = config('permission.table_names.permissions');

        $request->validate([
            '*.id' => "required|exists:{$permissionsTableName},uuid"
        ]);

        // Limpiamos la data obteniendo solo los uuid's
        $permissions = Arr::pluck($request->all(),'id');

        $role->syncPermissions($permissions);

        return $this->rolePermissions($role);
    }

    public function rolePermissions( RoleModel $role)
    {
        $result = UuidNameJsonResource::collection($role->permissions);
        
        return ResponseBuilder::success($result->resolve());
    }

    public function applyPermissibleMiddleware()
    {
        return $this->middleware(RolesMiddleware::class);
    }

}
