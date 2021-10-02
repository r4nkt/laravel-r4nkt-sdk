<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Leaderboards;

use R4nkt\LaravelR4nkt\Transporter\Concerns\AllowsPagination;

class ListLeaderboards extends LeaderboardRequest
{
    use AllowsPagination;

    protected string $method = 'GET';
}
