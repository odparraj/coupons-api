<?php


namespace Modules\Api\Http\Controllers;


use Modules\Api\Http\Middleware\Base\PermissibleMiddleware;
use Modules\Api\Repositories\TaxonomyRepository;
use Modules\Base\Http\Controllers\BaseController;

class TaxonomiesController extends BaseController
{
    protected $uuidToId = [
        //'key'=> Model::class,
    ];

    protected $arrValidate = [
        'name' => 'required|string|max:255',
    ];

    public function __construct(TaxonomyRepository $repository)
    {
        parent::__construct($repository);
        $this->middleware(PermissibleMiddleware::class);
    }
}