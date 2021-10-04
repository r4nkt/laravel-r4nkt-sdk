<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\LeaderboardRankings;

use Illuminate\Support\Str;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class LeaderboardRankingRequest extends R4nktRequest
{
    protected const BASE_PATH = 'leaderboards/{leaderboard-id}/rankings';

    protected string $path = self::BASE_PATH;

    protected string $customLeaderboardId;

    public function forCustomLeaderboardId(string $customLeaderboardId)
    {
        $this->customLeaderboardId = $customLeaderboardId;

        return $this;
    }

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
        $this->setPath((string) Str::of(self::BASE_PATH)->replace('{leaderboard-id}', $this->customLeaderboardId));
    }
}
