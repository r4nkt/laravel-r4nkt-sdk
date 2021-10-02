<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Leaderboards;

use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomId;

class DeleteLeaderboard extends LeaderboardRequest
{
    use HasCustomId;

    protected string $method = 'DELETE';

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomId();
    }

    protected function finalizePath()
    {
        $this->setPath(self::BASE_PATH . '/' . $this->customId);
    }
}
