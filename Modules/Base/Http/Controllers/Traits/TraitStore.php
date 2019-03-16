<?php

namespace Modules\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Validator;

trait TraitStore
{

    protected function __storeValid(Request $request)
    {
        $request->validate($this->arrValidate);
        
        //$validator = Validator::make($request->all(), $this->arrValidate);
        //if ($validator->fails())
        //    dd($validator->errors()->all());
    }

    protected function __storeGet(Request $request)
    {
        $data = $request->input();

        return $data;
    }

    protected function __storeProcess($data)
    {
        //Agregamos el UUID
        $data['uuid'] = Uuid::uuid4();
        
        return $data;
    }

    protected function __storeSave($data)
    {
        return $this->repository->store($data);
    }

    protected function __storeSent($result)
    {
        return $result;
    }
}