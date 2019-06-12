<?php


namespace Modules\Api\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Api\Entities\ProductModel;
use Modules\Api\Entities\TransactionModel;
use Modules\Api\Http\Resources\CartJsonResource;
use Modules\Api\Http\Resources\QuotaJsonResource;
use Modules\Base\General\ApiCode;
use Modules\Base\General\ResponseBuilder;
use Ramsey\Uuid\Uuid;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Order\Contracts\OrderFactory;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        Cart::restoreLastActiveCart($user);

        $cartModel= Cart::model();
        if($cartModel){
            $cartModel->load('items.product');
            return ResponseBuilder::success((new CartJsonResource($cartModel))->resolve());
        }else{
            return ResponseBuilder::success([]);
        }

    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,uuid',
            'quantity'=> 'integer'
        ]);

        $user = $request->user();
        Cart::restoreLastActiveCart($user);

        $product = ProductModel::whereUuid($request->product_id)->first();

        Cart::addItem($product,$request->quantity?:1);

        $cartModel= Cart::model();
        $cartModel->load('items.product');

        return ResponseBuilder::success((new CartJsonResource($cartModel))->resolve());
    }

    public function removeProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,uuid'
        ]);

        $user = $request->user();
        Cart::restoreLastActiveCart($user);

        $product = ProductModel::whereUuid($request->product_id)->first();

        Cart::removeProduct($product);

        $cartModel= Cart::model();
        $cartModel->load('items.product');

        return ResponseBuilder::success((new CartJsonResource($cartModel))->resolve());
    }

    public function checkout(Request $request, OrderFactory $orderFactory)
    {
        $user = $request->user();
        Cart::restoreLastActiveCart($user);

        $request->merge([
            'billpayer'=> [
                'firstname' => $user->name,
                'lastname'  => $user->name,
                'is_organization' => 0,
                'company_name' => 'required_if:billpayer.is_organization,1',
                'address'=> [
                    'address' => 'direction test',
                ],
            ],
            'ship_to_billing_address'=> 1,
            'shippingAddress'=> [
                'address' => 'required_unless:ship_to_billing_address,1'
            ]
        ]);

        $cartModel= Cart::model();

        if($cartModel){
            $quota= $request->user()->quota;

            if ($quota->amount_available > $cartModel->total() ){
                $newAmount= $quota->amount_available - $cartModel->total();
                $amountOld= $quota->amount_available;

                $quota->amount_available -= $cartModel->total();
                $quota->save();

                TransactionModel::create([
                    'uuid' => Uuid::uuid4(),
                    'quota_id' => $quota->id,
                    'operation_type_id' => 2,
                    'amount' => -1*$cartModel->total(),
                    'amount_old' => $amountOld,
                    'amount_new' => $newAmount
                ]);

                Cart::destroy();

                return ResponseBuilder::success((new QuotaJsonResource($quota))->resolve());
            }else{
                return ResponseBuilder::error(110);
            }
        }else{
            return ResponseBuilder::error(110);
        }
    }

}