<?php

namespace Dovutuan\Serpo\Repositories;

use BadMethodCallException;
use Dovutuan\Serpo\Contracts\RepositoryInterface;
use Dovutuan\Serpo\Traits\HasCriteria;
use Dovutuan\Serpo\Traits\QueryBuilderTrait;
use Dovutuan\Serpo\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @mixin Builder
 * @mixin Collection
 */
abstract class BaseRepository implements RepositoryInterface
{
    use HasCriteria;
    use QueryBuilderTrait;
    use QueryTrait;
    use ForwardsCalls;

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
     * Dynamically handle calls to the underlying Eloquent Builder or Model.
     *
     * - If the method exists on the current query builder, forward the call to it.
     * - If the method is not found on the builder, attempt to call it on a new model query.
     * - If the result is another Builder instance, update the current query and return $this
     *   to allow method chaining on the repository.
     * - Otherwise, return the raw result (e.g., Collection, Model, int, bool, etc.).
     *
     * @param string $method The method being called.
     * @param array $parameters The method parameters.
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call(string $method, array $parameters)
    {
        try {
            $result = $this->forwardCallTo($this->query, $method, $parameters);
        } catch (BadMethodCallException $e) {
            $result = $this->forwardCallTo($this->model->newModelQuery(), $method, $parameters);
        }

        if ($result instanceof Builder) {
            $this->query = $result;
            return $this;
        }

        return $result;
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
}
