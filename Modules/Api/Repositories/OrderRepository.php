<?php

namespace Modules\Api\Repositories;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Entities\OrderModel;
use Modules\Api\Http\Resources\OrderJsonResource;
use Modules\Base\Repositories\aResourceRepository;

class OrderRepository extends aResourceRepository
{
    protected $model = OrderModel::class;
    protected $jsonResource = JsonResource::class;
}