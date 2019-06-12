<?php


namespace Modules\Api\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Api\Entities\ProductModel;
use Modules\Api\Http\Resources\CartJsonResource;
use Modules\Base\General\ResponseBuilder;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Checkout\Contracts\Checkout;
use Vanilo\Order\Contracts\OrderFactory;

class CartController extends Controller
{
    protected $checkout;

    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

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

        $checkout = $this->checkout;
        $checkout->setCart($cartModel);
        $checkout->update($request->all());
        $order = $orderFactory->createFromCheckout($checkout);
        Cart::destroy();

        return $order;
        /*if($cartModel){
            $cartModel->load('items.product');
            return ResponseBuilder::success((new CartJsonResource($cartModel))->resolve());
        }else{
            return ResponseBuilder::success([]);
        }*/
    }

}