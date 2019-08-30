<?php

namespace Modules\Api\Http\Controllers;

use Modules\Api\Repositories\OrderRepository;
use Modules\Base\Http\Controllers\BaseController;

class OrderController extends BaseController
{

    protected $uuidToId = [
        //'key'=> Model::class,
        'user_id' => UserModel::class,
    ];

    protected $arrValidate = [
        'user_id'=> 'required|exists:users,uuid',
        'amount_enabled'=> 'required|numeric|min:0',
    ];

    public function __construct(OrderRepository $repository)
    {
        parent::__construct($repository);
        //$this->middleware(PermissibleMiddleware::class);
    }

}