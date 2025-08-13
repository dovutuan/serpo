<?php

namespace Dovutuan\Serpo\Traits;

use Dovutuan\Serpo\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait QueryTrait
{
    protected Builder $query;

    /**
     * Predefined filter conditions used by HasCriteria::filters().
     *
     * Structure example:
     * [
     *     'status' => [
     *         'class' => \App\Criteria\StatusCriteria::class,
     *         'columns' => 'status',
     *         'operator' => 'and'
     *     ],
     *     'search' => [
     *         'class' => \App\Criteria\SearchCriteria::class,
     *         'columns' => ['name', 'email']
     *     ]
     * ]
     *
     * @var array<string, array>
     */
    protected array $conditions = [];

    /**
     * Whether to reset the query builder instance after executing a query.
     *
     * @var bool
     */
    protected bool $autoReset = true;

    /**
     * Initialize or reset the query builder instance.
     *
     * @return QueryTrait|BaseRepository
     */
    abstract protected function initInstance(): self;

    /**
     * Disable automatic query builder reset after query execution.
     *
     * @return QueryTrait|BaseRepository
     */
    public function withoutAutoReset(): self
    {
        $this->autoReset = false;
        return $this;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param callable $callback
     * @return mixed
     */
    protected function executeQuery(callable $callback): mixed
    {
        $result = $callback();

        if ($this->autoReset) {
            $this->initInstance();
        }

        return $result;
    }

    /**
     * Retrieve all records from the repository.
     *
     * @param array $columns The columns to select.
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->executeQuery(fn() => $this->query->get($columns));
    }

    /**
     * Get a collection of results for the current query.
     *
     * @param array $columns The columns to select.
     * @return Collection
     */
    public function get(array $columns = ['*']): Collection
    {
        return $this->executeQuery(fn() => $this->query->get($columns));
    }

    /**
     * Get the first result of the current query.
     *
     * @param array $columns The columns to select.
     * @return Model|Builder|null
     */
    public function first(array $columns = ['*']): Model|Builder|null
    {
        return $this->executeQuery(fn() => $this->query->first($columns));
    }

    /**
     * Get the last record (latest by a given column or the default timestamp).
     *
     * @param string|null $orderBy Column to order by (default: model's created_at or updated_at).
     * @param array $columns Columns to select.
     * @return Model|Builder|null
     */
    public function last(?string $orderBy = null, array $columns = ['*']): Model|Builder|null
    {
        return $this->executeQuery(fn() => $this->query->latest($orderBy)->first($columns));
    }

    /**
     * Execute the query and get the first result or throw an exception.
     *
     * @param array $columns
     * @return Model|Builder
     * @throws ModelNotFoundException
     */
    public function firstOrFail(array $columns = ['*']): Model|Builder
    {
        return $this->executeQuery(fn() => $this->query->firstOrFail($columns));
    }
}
