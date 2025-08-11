<?php

namespace Dovutuan\Serpo\Criteria;

use Illuminate\Database\Eloquent\Builder;

class InCriteria extends BaseCriteria
{
    public function apply(Builder $query): void
    {
        $columns = $this->parseColumns();

        $query->when($this->value, function (Builder $query) use ($columns) {
            $query->where(function (Builder $query) use ($columns) {
                foreach ($columns as $column) {
                    $query->whereNotIn(column: $column, values: $this->value, boolean: $this->boolean);
                }
            });
        });
    }
}
