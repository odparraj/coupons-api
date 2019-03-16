<?php

namespace Modules\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait TraitIndex
{
    protected function __indexGetParams(Request $request)
    {
        return $request->all();
    }

    protected function __indexProcess(array $dataGet = [])
    {
        $result = $this->repository->filter($dataGet);

        return $result;
    }

    protected function __indexSent($arrResult)
    {
        if ($arrResult['meta'] && $arrResult['meta']['pagination']) {
            $arrResult['paginate'] = $arrResult['meta']['pagination'];
            unset($arrResult['meta']);
        }

        return $arrResult;
    }
}
