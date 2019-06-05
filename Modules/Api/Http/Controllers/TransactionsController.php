<?php


namespace Modules\Api\Http\Controllers;


use Modules\Api\Http\Middleware\Base\PermissibleMiddleware;
use Modules\Api\Repositories\TransactionRepository;

class TransactionsController extends BaseController
{
    protected $uuidToId = [
        //'key'=> Model::class,
    ];

    protected $arrValidate = [
        'name' => 'required|string|max:255',
    ];

    public function __construct(TransactionRepository $repository)
    {
        parent::__construct($repository);
        $this->middleware(PermissibleMiddleware::class);
    }

}