<?php

namespace Dovutuan\Serpo\Criteria;

use Dovutuan\Serpo\Contracts\CriteriaInterface;
use Dovutuan\Serpo\Traits\ParseColumnCriteria;
use Dovutuan\Serpo\Traits\ValidateCriteria;

abstract class BaseCriteria implements CriteriaInterface
{
    use ValidateCriteria;
    use ParseColumnCriteria;

    public function __construct(
        protected string|array $columns,
        protected string|int $value,
        protected string $boolean = 'and'
    ) {
        $this->validateColumns();
    }
}
