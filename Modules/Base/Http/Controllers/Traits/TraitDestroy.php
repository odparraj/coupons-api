<?php

namespace Modules\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait TraitDestroy
{
    protected function __destroySave($uuid)
    {
        return $this->repository->destroy($uuid);
    }

    protected function __destroySent($result)
    {
        if ($result['error']) {
            unset($result['data']);
            $result['error'] = 'Ha ocurrido un error al eliminar :(';
        } else {
            unset($result['error']);
        }

        return $result;
    }
}