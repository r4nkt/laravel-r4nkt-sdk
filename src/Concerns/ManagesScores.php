<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Jobs\SubmitScore as SubmitScoreJob;
use R4nkt\LaravelR4nkt\Support\Dtos\ScoreSubmissionData;
use R4nkt\LaravelR4nkt\Transporter\Scores\SubmitScore;

trait ManagesScores
{
    public function submitScore(string $customPlayerId, string $customLeaderboardId, int $score, ?Closure $callback = null)
    {
        $request = SubmitScore::build()
            ->customPlayerId($customPlayerId)
            ->customLeaderboardId($customLeaderboardId)
            ->score($score);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function queueScoreSubmission(
        string $customPlayerId,
        string $customLeaderboardId,
        int $score,
        ?string $dateTimeUtc = null,
    ) {
        SubmitScoreJob::dispatch(new ScoreSubmissionData(
            customPlayerId: $customPlayerId,
            customLeaderboardId: $customLeaderboardId,
            score: $score,
            dateTimeUtc: $dateTimeUtc,
        ));
    }
}
