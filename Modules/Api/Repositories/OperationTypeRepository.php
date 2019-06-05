<?php


namespace Modules\Api\Repositories;


use Modules\Api\Entities\OperationTypeModel;
use Modules\Api\Http\Resources\OperationTypeJsonResource;
use Modules\Base\Repositories\aResourceRepository;

class OperationTypeRepository extends aResourceRepository
{
    protected $model = OperationTypeModel::class;
    protected $jsonResource = OperationTypeJsonResource::class;
}