<?php

namespace Dovutuan\Serpo\Traits;

trait ParseColumnCriteria
{
    protected function parseColumns(): array
    {
        if (is_array($this->columns)) {
            return $this->columns;
        }

        return explode('|', $this->columns);
    }
}
