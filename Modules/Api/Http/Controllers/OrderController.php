<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Routing\Controller;
use Vanilo\Order\Models\Order;

class OrderController extends Controller
{

    public function index()
    {
        return Order::all();
    }

}