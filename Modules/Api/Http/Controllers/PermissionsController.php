<?php

namespace Modules\Api\Http\Controllers;

use Modules\Api\Http\Middleware\PermissionsMiddleware;
use Modules\Api\Repositories\PermissionRepository;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Middleware\iPermissibleMiddleware;

class PermissionsController extends BaseController implements iPermissibleMiddleware
{
    protected $uuidToId = [
        //'product_type_id'=> \Modules\CoreBanking\Entities\ProductTypeModel::class,
        //'company_id'=> \Modules\CoreBanking\Entities\CompanyModel::class,
    ];

    protected $arrValidate = [
        'name' => 'required|string|max:255'
    ];

    public function __construct(PermissionRepository $repository)
    {
        parent::__construct($repository);
        $this->applyPermissibleMiddleware();
    }

    public function applyPermissibleMiddleware()
    {
        return $this->middleware(PermissionsMiddleware::class);
    }

}