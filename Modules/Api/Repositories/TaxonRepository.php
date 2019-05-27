<?php


namespace Modules\Api\Repositories;


use Modules\Api\Entities\TaxonModel;
use Modules\Api\Http\Resources\TaxonJsonResource;
use Modules\Base\Repositories\aResourceRepository;

class TaxonRepository extends aResourceRepository
{
    protected $model = TaxonModel::class;
    protected $jsonResource = TaxonJsonResource::class;
}