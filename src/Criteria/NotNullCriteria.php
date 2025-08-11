<?php

namespace Dovutuan\Serpo\Criteria;

use Illuminate\Database\Eloquent\Builder;

class NotNullCriteria extends BaseCriteria
{
    public function apply(Builder $query): void
    {
        $columns = $this->parseColumns();

        $query->when($this->value, function (Builder $query) use ($columns) {
            $query->whereNotNull(columns: $columns, boolean: $this->boolean);
        });
    }
}
