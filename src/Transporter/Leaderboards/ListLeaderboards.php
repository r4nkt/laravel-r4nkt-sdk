<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Leaderboards;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class ListLeaderboards extends R4nktRequest
{
    protected string $method = 'GET';
    protected string $path = 'leaderboards';
}
