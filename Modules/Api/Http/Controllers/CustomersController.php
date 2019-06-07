<?php


namespace Modules\Api\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Api\Entities\ProductModel;
use Modules\Api\Http\Middleware\Base\PermissibleMiddleware;
use Modules\Api\Repositories\UserRepository;
use Modules\Base\General\ResponseBuilder;
use Modules\Base\Http\Controllers\BaseController;

class CustomersController extends BaseController
{
    protected $uuidToId = [
        //'product_type_id'=> \Modules\CoreBanking\Entities\ProductTypeModel::class,
        //'company_id'=> \Modules\CoreBanking\Entities\CompanyModel::class,
    ];

    //companies agregar
    protected $arrValidate = [
        'name' => 'required|string|max:255',
        'email'=> 'required|string|unique:users',
    ];

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);

        $this->middleware(PermissibleMiddleware::class);
    }

    protected function __storeGet(Request $request)
    {
        $data = $request->input();

        $data['password'] = '';

        return $data;
    }

    protected function __updateGet(Request $request)
    {
        $data = $request->input();

        if (!empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }

    protected function __storeSave($data)
    {
        return $this->repository->store($data,false);
    }

    public function meCustomersIndex(Request $request)
    {
        $request->merge([
            'created_by' => $request->user()->id
        ]);

        return parent::index($request);
    }

    public function meCustomersStore(Request $request)
    {
        $user= $this->store($request);

        if($user){
            $user->assignRole('customer');
            $user->assignQuota();
            return ResponseBuilder::success(['id'=> $user->uuid]);
        }else{
            return ResponseBuilder::error(110);
        }
    }

    public function meCustomersShow(Request $request, $uuid)
    {
        if($request->user()->customers()->whereUuid($uuid)->count()>0){
            return parent::show($request, $uuid);
        }else {
            return ResponseBuilder::error(110);
        }
    }

    public function meCustomersUpdate(Request $request, $uuid)
    {
        if($request->user()->customers()->whereUuid($uuid)->count()>0){
            return parent::update($request, $uuid);
        }else {
            return ResponseBuilder::error(110);
        }
    }

    public function meCustomersDestroy(Request $request, $uuid)
    {
        if($request->user()->customers()->whereUuid($uuid)->count()>0){
            return parent::destroy($request, $uuid);
        }else {
            return ResponseBuilder::error(110);
        }
    }
}