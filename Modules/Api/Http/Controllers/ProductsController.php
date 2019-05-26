<?php


namespace Modules\Api\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Api\Entities\ProductModel;
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
        'sku' => 'required|string|max:255',
        'description'=> 'required|string',
        'price'=> 'required|numeric',


    ];

    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(Request $request)
    {
        $images= $request->files->filter('images');
        $response = parent::store($request);

        if (!empty($images) && isset($response['data']['id'])) {
            $product= ProductModel::whereUuid($response['data']['id'])->first();
            if ($product){

                $product->addMultipleMediaFromRequest(['images'])->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection();
                });
            }

        }

        return $response;
    }
}