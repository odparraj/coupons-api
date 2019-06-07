<?php


namespace Modules\Api\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Modules\Api\Entities\ProductModel;
use Modules\Api\Entities\TransactionModel;
use Modules\Api\Http\Middleware\Base\PermissibleMiddleware;
use Modules\Api\Http\Resources\QuotaJsonResource;
use Modules\Api\Http\Resources\TransactionJsonResource;
use Modules\Api\Repositories\UserRepository;
use Modules\Base\General\ResponseBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Ramsey\Uuid\Uuid;

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

    public function getQuota(Request $request, $uuid)
    {
        if($request->user()->customers()->whereUuid($uuid)->count()>0){
            $quota= $request->user()->customers()->whereUuid($uuid)->first()->quota;
            return ResponseBuilder::success((new QuotaJsonResource($quota))->resolve());
        }else {
            return ResponseBuilder::error(110);
        }
    }

    public function getTransactions(Request $request, $uuid)
    {
        if($request->user()->customers()->whereUuid($uuid)->count()>0){
            $transactions= $request->user()->customers()->whereUuid($uuid)->first()->quota->transactions()->paginate(15);
            return ResponseBuilder::success(TransactionJsonResource::collection($transactions));

        }else {
            return ResponseBuilder::error(110);
        }
    }

    public function updateQuota(Request $request, $uuid)
    {
        $request->validate([
            'amount'=> 'required|numeric',
            'is_active'=> 'boolean',
        ]);

        if($request->user()->customers()->whereUuid($uuid)->count()>0){

            $quota= $request->user()->customers()->whereUuid($uuid)->first()->quota;
            $newAmount= $quota->amount_available + $request->amount;
            if( $newAmount > 0 ){
                $input= $request->input();

                $amountOld= $quota->amount_available;

                $quota->amount_enabled += $request->amount;
                $quota->amount_available= $newAmount;

                if( isset($input['is_active']) ){
                    $quota->is_active= $request->is_active;
                }

                $quota->save();

                TransactionModel::create([
                    'uuid' => Uuid::uuid4(),
                    'quota_id' => $quota->id,
                    'operation_type_id' => 2,
                    'amount' => $request->amount,
                    'amount_old' => $amountOld,
                    'amount_new' => $newAmount
                ]);

                return ResponseBuilder::success((new QuotaJsonResource($quota))->resolve());

            }else{
                return ResponseBuilder::errorWithHttpCode(110,422);
            }

        }else {
            return ResponseBuilder::error(110);
        }
    }
}