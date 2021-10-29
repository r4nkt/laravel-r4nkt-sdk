<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Leaderboards;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomIdInPath;

#[Requires('custom-id')]
class DeleteLeaderboard extends LeaderboardRequest
{
    use HasCustomIdInPath;

    protected string $method = 'DELETE';

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
    }
}
