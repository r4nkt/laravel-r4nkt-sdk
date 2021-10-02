<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Players;

use R4nkt\LaravelR4nkt\Transporter\Concerns\AllowsPagination;

class ListPlayers extends PlayerRequest
{
    use AllowsPagination;

    protected string $method = 'GET';
}
