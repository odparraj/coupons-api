<?php

namespace Modules\Base\Filters;

use EloquentFilter\ModelFilter;

use Modules\Base\Filters\Traits\TraitFields;
use Modules\Base\Filters\Traits\TraitFilter;
use Modules\Base\Filters\Traits\TraitSort;

class BaseFilter extends ModelFilter
{
    use TraitFilter, TraitSort, TraitFields;

    protected $arrFieldsSearch = [];

    public function __construct($query, array $input = [], bool $relationsEnabled = true)
    {
        if (empty($this->arrFieldsSearch)) {
            throw new \Exception('El arreglo $arrFieldsSearch no puede ser vacio.');
        }

        parent::__construct($query, $input, $relationsEnabled);
    }
}
