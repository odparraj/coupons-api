<?php


namespace Modules\Api\Http\Controllers;


use Modules\Api\Entities\TaxonModel;
use Modules\Api\Entities\TaxonomyModel;
use Modules\Api\Http\Middleware\Base\PermissibleMiddleware;
use Modules\Api\Repositories\TaxonRepository;
use Modules\Base\Http\Controllers\BaseController;

class TaxonsController extends BaseController
{
    protected $uuidToId = [
        'parent_id' => TaxonModel::class,
        'taxonomy_id'=> TaxonomyModel::class,
    ];

    protected $arrValidate = [
        'name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:taxons,uuid',
        'taxonomy_id' => 'required|exists:taxonomies,uuid'
    ];

    public function __construct(TaxonRepository $repository)
    {
        parent::__construct($repository);
        $this->middleware(PermissibleMiddleware::class);
    }
}