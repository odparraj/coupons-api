<?php

namespace Modules\Base\Transformers;

use \League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    protected function __valid($model, $strAttr)
    {
        return in_array($strAttr, $model->getFillable()) && isset($model->getAttributes()[$strAttr]);
    }

    protected function __getGeneric($model, $strAttrReturn, $strAttrReal = null, $strClass = null)
    {
        $strAttrReal = $strAttrReal ?? $strAttrReturn;

        $result = [];

        if ($this->__valid($model, $strAttrReal)) {
            if (!is_null($strClass)) {
                $modelID = (new $strClass)->select('uuid')->find($model->{$strAttrReal});

                $result = [$strAttrReturn => is_null($modelID)?  null : $modelID->uuid];
            } else {
                $result = [$strAttrReturn => $model->{$strAttrReal}];
            }
        }

        return $result;
    }
}
