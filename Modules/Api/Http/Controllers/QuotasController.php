<?php


namespace Modules\Api\Http\Controllers;


use Modules\Api\Entities\UserModel;
use Modules\Api\Http\Middleware\Base\PermissibleMiddleware;
use Modules\Api\Repositories\QuotaRepository;
use Modules\Base\Http\Controllers\BaseController;

class QuotasController extends BaseController
{
    protected $uuidToId = [
        //'key'=> Model::class,
        'user_id' => UserModel::class,
    ];

    protected $arrValidate = [
        'user_id'=> 'required|exists:users,uuid',
        'amount_enabled'=> 'required|numeric|min:0',
    ];

    public function __construct(QuotaRepository $repository)
    {
        parent::__construct($repository);
        $this->middleware(PermissibleMiddleware::class);
    }

}