<?php

namespace Dovutuan\Serpo\Contracts;

interface RepositoryInterface
{
    public function all(array $columns = ['*']);
}
