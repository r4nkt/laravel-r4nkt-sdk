<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\LeaderboardRankings;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

#[Requires('custom-leaderboard-id')]
class LeaderboardRankingRequest extends R4nktRequest
{
    protected string $customLeaderboardId;

    protected function guardAgainstMissingCustomLeaderboardId()
    {
        if (! isset($this->customLeaderboardId)) {
            throw IncompleteRequest::missingRequiredParameter('custom leaderboard ID');
        }
    }

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addToPath("leaderboards/{$this->customLeaderboardId}/rankings");
    }

    public function forCustomLeaderboardId(string $customLeaderboardId)
    {
        $this->customLeaderboardId = $customLeaderboardId;

        return $this;
    }
}
