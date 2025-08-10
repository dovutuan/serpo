<?php

namespace Dovutuan\Serpo\Traits;

trait HasCriteria
{
    public function filters(array|null $filters = null): self
    {
        foreach ($filters as $key => $value) {
            if (isset($this->conditions[$key])) {
                $criteriaClass = $this->conditions[$key]['class'];
                $columns = $this->conditions[$key]['columns'] ?? $key;
                $boolean = $this->conditions[$key]['operator'] ?? 'and';

                $criteria = new $criteriaClass($columns, $value, $boolean);

                $criteria->apply($this->query);
            }
        }

        return $this;
    }
}
