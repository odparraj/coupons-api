<?php


namespace Modules\Api\Repositories;


use Modules\Api\Entities\ProductModel;
use Modules\Base\Repositories\aResourceRepository;
use Modules\Api\Http\Resources\ProductJsonResource;

class ProductRepository extends aResourceRepository
{
    protected $model = ProductModel::class;
    protected $jsonResource = ProductJsonResource::class;
}