<?php


namespace Modules\Api\Repositories;


use Modules\Api\Entities\TaxonomyModel;
use Modules\Api\Http\Resources\TaxonomyJsonResource;
use Modules\Base\Repositories\aResourceRepository;

class TaxonomyRepository extends aResourceRepository
{
    protected $model = TaxonomyModel::class;
    protected $jsonResource = TaxonomyJsonResource::class;
}