<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Players;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class PlayerRequest extends R4nktRequest
{
    protected const BASE_PATH = 'players';

    protected string $path = self::BASE_PATH;
}
