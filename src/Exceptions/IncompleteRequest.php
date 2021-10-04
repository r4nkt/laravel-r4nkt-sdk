<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Exceptions;

use Exception;

class IncompleteRequest extends Exception
{
    public static function missingRequiredParameter(string $missingParameter): self
    {
        return new static("Missing required request parameter: {$missingParameter}.");
    }
}
