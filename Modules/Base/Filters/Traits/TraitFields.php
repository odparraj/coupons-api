<?php

namespace Modules\Base\Filters\Traits;

trait TraitFields
{
    public function fields($allFields)
    {
        $arrFields = explode(',', $allFields);

        if (!empty($arrFields)) {
            foreach ($arrFields as $index => $value) {
                if ($value == 'id') {
                    $arrFields[$index] = 'uuid';
                }
            }

            $this->select($arrFields);
        }

        return $this;
    }
}
