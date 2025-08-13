<?php

namespace Dovutuan\Serpo\Exceptions;

use InvalidArgumentException;

class InvalidCriteriaException extends InvalidArgumentException
{
    public static function forFields($columns): self
    {
        return new self(
            sprintf(
                'Invalid fields format. Expected string or array of strings, got: %s',
                is_object($columns) ? get_class($columns) : gettype($columns)
            )
        );
    }
}
