<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\PlayerBadges;

use R4nkt\LaravelR4nkt\Transporter\Concerns\AllowsPagination;

class ListPlayerBadges extends PlayerBadgeRequest
{
    use AllowsPagination;

    protected string $method = 'GET';

    public function includeAchievement()
    {
        return $this->include('achievement');
    }

    public function includePlayer()
    {
        return $this->include('player');
    }
}
