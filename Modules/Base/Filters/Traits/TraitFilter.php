<?php

namespace Modules\Base\Filters\Traits;

trait TraitFilter
{
    public function id($text)
    {
        if (in_array('id', $this->arrFieldsSearch)) {
            return $this->where('uuid', '=', $text);
        }

        return $this;
    }

    public function name($text)
    {
        if (in_array('name', $this->arrFieldsSearch)) {
            return $this->whereLike('name', $text);
        }

        return $this;
    }

    public function description($text)
    {
        if (in_array('description', $this->arrFieldsSearch)) {
            return $this->whereLike('description', $text);
        }

        return $this;
    }
}
