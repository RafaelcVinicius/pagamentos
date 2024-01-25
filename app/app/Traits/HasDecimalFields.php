<?php

namespace App\Traits;

trait HasDecimalFields
{
    private $delta = 1000000;
    public function setDecimal($value)
    {
        if ($value) {
            return $value * $this->delta;
        } else {
            return $value;
        }
    }

    public function getDecimal($value)
    {
        if ($value) {
            return $value / $this->delta;
        } else {
            return $value;
        }
    }
}