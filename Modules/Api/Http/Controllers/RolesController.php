<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Api\Entities\RoleModel;
use Modules\Api\Repositories\RoleRepository;
use Modules\Base\Http\Controllers\BaseController;

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
            '*.id' => "exists:{$permissionsTableName},uuid"
        ]);

        $role->syncPermissions($request->all());

        return response()->json(['data'=>$request->all()]);
    }

}