<?php


namespace Modules\Api\Repositories;


use Modules\Api\Entities\TransactionModel;
use Modules\Api\Http\Resources\TransactionJsonResource;
use Modules\Base\Repositories\aResourceRepository;

class TransactionRepository extends aResourceRepository
{
    protected $model = TransactionModel::class;
    protected $jsonResource = TransactionJsonResource::class;
}