<?php


namespace Modules\Api\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Api\Entities\ProductModel;
use Modules\Api\Http\Middleware\Base\PermissibleMiddleware;
use Modules\Api\Repositories\ProductRepository;
use Modules\Base\General\ResponseBuilder;
use Modules\Base\Http\Controllers\BaseController;

class ProductsController extends BaseController
{
    protected $uuidToId = [
        'parent_id'=> ProductModel::class
    ];

    protected $arrValidate = [
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:255',
        'description'=> 'required|string',
        'price'=> 'required|numeric',
        'type'=> 'required|in:product,service,additional',
        'parent_id'=> 'required_if:type,additional|exists:products,uuid'

    ];

    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
        $this->middleware(PermissibleMiddleware::class);
    }

    public function meProductsIndex(Request $request)
    {
        $request->merge([
            'created_by' => $request->user()->id
        ]);

        return parent::index($request);
    }

    public function meProductsStore(Request $request)
    {
        return $this->store($request);
    }

    public function meProductsShow(Request $request, $uuid)
    {
        if($request->user()->products()->whereUuid($uuid)->count()>0){
            return parent::show($request, $uuid);
        }else {
            return ResponseBuilder::error(110);
        }
    }

    public function meProductsUpdate(Request $request, $uuid)
    {
        if($request->user()->products()->whereUuid($uuid)->count()>0){
            return parent::update($request, $uuid);
        }else {
            return ResponseBuilder::error(110);
        }
    }

    public function meProductsDestroy(Request $request, $uuid)
    {
        if($request->user()->products()->whereUuid($uuid)->count()>0){
            return parent::destroy($request, $uuid);
        }else {
            return ResponseBuilder::error(110);
        }
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