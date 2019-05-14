<?php


namespace Modules\Api\Http\Controllers;


use Modules\Api\Repositories\ProductRepository;
use Modules\Base\Http\Controllers\BaseController;

class ProductsController extends BaseController
{
    protected $uuidToId = [
        //'product_type_id'=> \Modules\CoreBanking\Entities\ProductTypeModel::class,
        //'company_id'=> \Modules\CoreBanking\Entities\CompanyModel::class,
    ];

    protected $arrValidate = [
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:255'
    ];

    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }
}