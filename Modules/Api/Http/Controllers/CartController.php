<?php


namespace Modules\Api\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Api\Entities\ProductModel;
use Modules\Base\General\ResponseBuilder;

class CartController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,uuid',
            'quantity'=> 'integer'
        ]);

        $user = $request->user();
        Cart::restoreLastActiveCart($user);

        $product = ProductModel::find($request->product_id);

        Cart::addItem($product,1);
        return ResponseBuilder::success(Cart::model()->toArray());
    }
}