<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Scores;

use R4nkt\LaravelR4nkt\Transporter\Concerns;

class SubmitScore extends ScoreRequest
{
    use Concerns\PassesCustomPlayerId;
    use Concerns\PassesDateTimeUtc;

    protected string $method = 'POST';

    public function customLeaderboardId(string $customLeaderboardId)
    {
        return $this->withData(['custom_leaderboard_id' => $customLeaderboardId]);
    }

    public function score(int $score)
    {
        return $this->withData(['score' => $score]);
    }
}
