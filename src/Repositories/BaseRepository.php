<?php

namespace Dovutuan\Serpo\Repositories;

use Dovutuan\Serpo\Contracts\RepositoryInterface;
use Dovutuan\Serpo\Traits\HasCriteria;
use Dovutuan\Serpo\Traits\QueryBuilderTrait;
use Dovutuan\Serpo\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    use HasCriteria;
    use QueryBuilderTrait;
    use QueryTrait;

    /**
     * The underlying Eloquent model instance.
     *
     * @var Model
     */
    protected Model $model;

    /**
     * The query builder instance for building queries on the model.
     *
     * @var Builder
     */
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
     * Create a new repository instance.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->initInstance();
    }

    /**
     * Initialize or reset the query builder instance.
     *
     * @return self
     */
    private function initInstance(): self
    {
        $this->query = $this->model->newQuery();
        return $this;
    }

    /**
     * Create a new record in the repository.
     *
     * @param array $attributes The attributes for the new record.
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->executeQuery(fn() => $this->query->create($attributes));
    }

    /**
     * Update records in the current query with the given values.
     *
     * ⚠️ Warning: If no WHERE conditions are applied before calling this method,
     * it will update all rows in the table.
     *
     * @param array $values The column-value pairs to update.
     * @return int Number of affected rows.
     */
    public function update(array $values): int
    {
        return $this->executeQuery(fn() => $this->query->update($values));
    }

    /**
     * Delete records from the current query.
     *
     * ⚠️ Warning: If no WHERE conditions are applied before calling this method,
     * it will delete all rows in the table.
     *
     * @return int Number of deleted rows.
     */
    public function delete(): int
    {
        return $this->executeQuery(fn() => $this->query->delete());
    }
}
