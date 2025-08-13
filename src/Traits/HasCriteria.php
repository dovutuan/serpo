<?php

namespace Dovutuan\Serpo\Traits;

use Dovutuan\Serpo\Repositories\BaseRepository;

trait HasCriteria
{
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
     * Apply an array of criteria filters to the current query.
     *
     * This method loops through the provided filters array, checks if the filter key
     * matches any predefined conditions in `$this->conditions`, and then:
     * - Resolves the corresponding Criteria class
     * - Passes the target columns, filter value, and boolean operator
     * - Applies the criteria to `$this->query`
     *
     * Example:
     * $this->filters([
     *     'status' => 'active',
     *     'category' => 5
     * ]);
     *
     * @param array|null $filters Associative array where key is the filter name and value is the filter value
     * @return HasCriteria|BaseRepository
     */
    public function filters(array|null $filters = null): self
    {
        foreach ($filters as $key => $value) {
            if (isset($this->conditions[$key])) {
                $criteriaClass = $this->conditions[$key]['class'];
                $columns = $this->conditions[$key]['columns'] ?? $key;
                $boolean = $this->conditions[$key]['operator'] ?? 'and';

                $criteria = new $criteriaClass($columns, $value, $boolean);

                $criteria->apply($this->query);
            }
        }

        return $this;
    }
}
