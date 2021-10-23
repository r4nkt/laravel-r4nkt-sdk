<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\LeaderboardRankings;

use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class LeaderboardRankingRequest extends R4nktRequest
{
    protected string $customLeaderboardId;

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomLeaderboardId();
    }

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
