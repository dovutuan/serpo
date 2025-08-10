<?php

namespace Dovutuan\Serpo\Repositories;

use Dovutuan\Serpo\Contracts\RepositoryInterface;
use Dovutuan\Serpo\Traits\HasCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    use HasCriteria;

    private Model $model;

    private Builder $query;

    protected array $conditions = [];

    protected bool $autoReset = true;

    public function __construct(Model $model)
    {
        $this->model = $model;

        $this->initInstance();
    }

    public function initInstance(): self
    {
        $this->query = $this->model->newQuery();
        return $this;
    }

    public function withoutAutoReset(): self
    {
        $this->autoReset = false;
        return $this;
    }

    protected function executeQuery($callback)
    {
        $result = $callback();

        if ($this->autoReset) {
            $this->initInstance();
        }

        return $result;
    }

    public function all(array $columns = ['*'])
    {
        return $this->executeQuery(fn() => $this->query->get($columns));
    }
}
