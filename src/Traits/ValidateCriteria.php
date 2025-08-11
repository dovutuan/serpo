<?php

namespace Dovutuan\Serpo\Traits;

use Dovutuan\Serpo\Exceptions\InvalidCriteriaException;

trait ValidateCriteria
{
    private function validateColumns(): void
    {
        if (is_string($this->columns)) {
            if (empty(trim($this->columns)) || str_contains($this->columns, ' ')) {
                throw new InvalidCriteriaException("Invalid columns format. Expected 'field' or 'field1|field2', got: " . $this->columns);
            }
            return;
        }

        if (is_array($this->columns)) {
            if (empty($this->columns)) {
                throw new InvalidCriteriaException("Columns array cannot be empty");
            }

            foreach ($this->columns as $field) {
                if (!is_string($field) || empty(trim($field))) {
                    throw new InvalidCriteriaException("Invalid field in array. All columns must be non-empty strings");
                }
            }
            return;
        }

        throw new InvalidCriteriaException("Columns must be string or array, got: " . gettype($this->columns));
    }
}
