<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Actions;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class ActionRequest extends R4nktRequest
{
    protected const BASE_PATH = 'actions';

    protected string $path = self::BASE_PATH;
}
