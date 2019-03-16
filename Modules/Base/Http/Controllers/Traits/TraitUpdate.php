<?php

namespace Modules\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait TraitUpdate
{

    protected function __updateValid(Request $request)
    {
        $request->validate($this->arrValidateUpdate);
    }

    protected function __updateGet(Request $request)
    {
        $data = $request->input();

        return $data;
    }

    protected function __updateProcess($data)
    {
        //No permito que editen el uuid
        if (!empty($data['uuid'])) {
            unset($data['uuid']);
        }

        return $data;
    }

    protected function __updateSave($uuid, $data)
    {
        return $this->repository->update($uuid, $data);
    }

    protected function __updateSent($result)
    {
        return $result;
    }
}