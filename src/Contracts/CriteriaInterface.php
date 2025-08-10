<?php

namespace Dovutuan\Serpo\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface CriteriaInterface
{
    public function apply(Builder $query);
}
