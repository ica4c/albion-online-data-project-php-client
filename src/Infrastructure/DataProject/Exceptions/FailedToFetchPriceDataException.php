<?php

namespace Albion\OnlineDataProject\Infrastructure\DataProject\Exceptions;

use Exception;
use Throwable;

class FailedToFetchPriceDataException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            $previous ?
                sprintf("Failed to fetch prices data due to %s", $previous->getMessage()) :
                "Failed to fetch prices data",
            400,
            $previous
        );
    }
}