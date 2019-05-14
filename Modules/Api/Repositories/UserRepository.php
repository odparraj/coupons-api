<?php

namespace Modules\Api\Repositories;

use Modules\Base\Repositories\aResourceRepository;
use Modules\Api\Entities\UserModel;
use Modules\Api\Http\Resources\UserJsonResource;

class UserRepository extends aResourceRepository
{
    protected $model = UserModel::class;
    protected $jsonResource = UserJsonResource::class;
}


