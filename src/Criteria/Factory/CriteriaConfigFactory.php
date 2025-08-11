<?php

namespace Dovutuan\Serpo\Criteria\Factory;

class CriteriaConfigFactory
{
    public static function create(
        string $class,
        string|array $columns,
        string $operator = 'and',
        array $params = []
    ): array {
        return [
            'class' => $class,
            'columns' => $columns,
            'operator' => $operator,
            'params' => $params
        ];
    }
}