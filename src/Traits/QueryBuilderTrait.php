<?php

namespace Dovutuan\Serpo\Traits;

use Dovutuan\Serpo\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

trait QueryBuilderTrait
{
    protected Builder $query;

    /**
     * Select specific columns
     *
     * @param array $columns Columns to select
     * @return QueryBuilderTrait|BaseRepository
     */
    public function select(array $columns = ['*']): self
    {
        $this->query->select($columns);
        return $this;
    }

    /**
     * Eager load relationships
     *
     * @param array|string $relations
     * @return QueryBuilderTrait|BaseRepository
     */
    public function with(array|string $relations): self
    {
        $this->query->with($relations);
        return $this;
    }
}
