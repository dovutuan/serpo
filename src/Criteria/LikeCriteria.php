<?php

namespace Dovutuan\Serpo\Criteria;

use Dovutuan\Serpo\Criteria\__Base\BaseCriteria;
use Illuminate\Database\Eloquent\Builder;

class LikeCriteria extends BaseCriteria
{
    public function apply(Builder $query): void
    {
        $columns = $this->parseColumns();

        $query->when($this->value, function (Builder $query) use ($columns) {
            $query->where(function (Builder $query) use ($columns) {
                foreach ($columns as $coumn) {
                    $query->where(column: $coumn, operator: 'like', value: "%$this->value%", boolean: $this->boolean);
                }
            });
        });
    }
}
