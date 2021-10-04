<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Scores;

class SubmitScore extends ScoreRequest
{
    protected string $method = 'POST';

    public function customPlayerId(string $customPlayerId)
    {
        return $this->withData(['custom_player_id' => $customPlayerId]);
    }

    public function customLeaderboardId(string $customLeaderboardId)
    {
        return $this->withData(['custom_leaderboard_id' => $customLeaderboardId]);
    }

    public function score(int $score)
    {
        return $this->withData(['score' => $score]);
    }

    public function dateTimeUtc(string $dateTimeUtc)
    {
        return $this->withData(['date_time_utc' => $dateTimeUtc]);
    }
}
