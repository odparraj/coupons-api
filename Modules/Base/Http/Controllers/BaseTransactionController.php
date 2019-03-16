<?php

namespace Modules\Base\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BaseTransactionController extends BaseController
{

    protected function __storeSave($data)
    {
        $result = null;

        try {
            DB::beginTransaction();

            $result = parent::__storeSave($data);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $result;
    }

    protected function __updateSave($uuid, $data)
    {
        $result = null;

        try {
            DB::beginTransaction();

            $result = parent::__updateSave($uuid, $data);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $result;
    }

    protected function __destroySave($uuid)
    {
        $result = null;

        try {
            DB::beginTransaction();

            $result = parent::__destroySave($uuid);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $result;
    }
}
