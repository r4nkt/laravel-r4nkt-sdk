<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\LeaderboardRankings;

use R4nkt\LaravelR4nkt\Transporter\Concerns\AllowsPagination;

class ListLeaderboardRankings extends LeaderboardRankingRequest
{
    use AllowsPagination;

    protected string $method = 'GET';
}
