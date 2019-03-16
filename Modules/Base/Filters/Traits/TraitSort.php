<?php

namespace Modules\Base\Filters\Traits;

trait TraitSort
{
    public function sort($allSort)
    {
        $arrSort = explode(',', $allSort);

        foreach ($arrSort as $sort) {
            $arrOrderBy = explode('-', $sort);

            $dir = 'asc';
            $field = $arrOrderBy[0];

            if (count($arrOrderBy) == 2) {
                $dir = 'desc';
                $field = $arrOrderBy[1];
            }

            $this->orderBy($field, $dir);
        }

        return $this;
    }
}
