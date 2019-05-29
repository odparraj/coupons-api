<?php

namespace Modules\Api\Http\Controllers;

use Modules\Api\Http\Middleware\Base\PermissibleMiddleware;
use Modules\Api\Repositories\PermissionRepository;
use Modules\Base\Http\Controllers\BaseController;;

class PermissionsController extends BaseController
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
        $this->middleware(PermissibleMiddleware::class);
    }

}