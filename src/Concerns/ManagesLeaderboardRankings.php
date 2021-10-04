<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Transporter\LeaderboardRankings\ListLeaderboardRankings;

trait ManagesLeaderboardRankings
{
    public function listLeaderboardRankings(string $customLeaderboardId, ?Closure $callback = null)
    {
        $request = ListLeaderboardRankings::build()
            ->forCustomLeaderboardId($customLeaderboardId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }
}
