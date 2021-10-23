<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Leaderboards;

use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomIdInPath;

class DeleteLeaderboard extends LeaderboardRequest
{
    use HasCustomIdInPath;

    protected string $method = 'DELETE';

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomId();
    }

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
    }
}
