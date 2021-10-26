<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use R4nkt\LaravelR4nkt\Support\Dtos\ScoreSubmissionData;
use R4nkt\LaravelR4nkt\Transporter\Scores\SubmitScore as SubmitScoreTransporter;

class SubmitScore implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private ScoreSubmissionData $scoreSubmission,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SubmitScoreTransporter::build()
            ->customPlayerId($this->scoreSubmission->customPlayerId)
            ->customLeaderboardId($this->scoreSubmission->customLeaderboardId)
            ->score($this->scoreSubmission->score)
            ->if(
                $this->scoreSubmission->dateTimeUtc,
                fn ($request) => $request->customDateTimeUtc($this->scoreSubmission->dateTimeUtc),
            )
            ->send();
    }
}
