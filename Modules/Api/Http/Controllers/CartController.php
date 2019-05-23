<?php


namespace Modules\Api\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Api\Entities\ProductModel;
use Modules\Api\Http\Resources\CartJsonResource;
use Modules\Base\General\ResponseBuilder;
use Vanilo\Cart\Facades\Cart;

class CartController extends Controller
{
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

}