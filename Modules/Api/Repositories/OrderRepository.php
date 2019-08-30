<?php

namespace Modules\Api\Repositories;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Base\Repositories\aResourceRepository;
use Vanilo\Order\Models\Order;

class OrderRepository extends aResourceRepository
{
    protected $model = Order::class;
    protected $jsonResource = JsonResource::class;
}