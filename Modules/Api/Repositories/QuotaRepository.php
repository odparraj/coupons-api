<?php


namespace Modules\Api\Repositories;


use Modules\Api\Entities\QuotaModel;
use Modules\Api\Http\Resources\QuotaJsonResource;
use Modules\Base\Repositories\aResourceRepository;

class QuotaRepository extends aResourceRepository
{
    protected $model = QuotaModel::class;
    protected $jsonResource = QuotaJsonResource::class;
}