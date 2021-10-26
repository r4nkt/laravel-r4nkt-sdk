<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use R4nkt\LaravelR4nkt\Support\Dtos\ActivityData;
use R4nkt\LaravelR4nkt\Transporter\Activities\ReportActivity as ReportActivityTransporter;

class ReportActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private ActivityData $activity,
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ReportActivityTransporter::build()
            ->customPlayerId($this->activity->customPlayerId)
            ->customActionId($this->activity->customActionId)
            ->if(
                $this->activity->amount,
                fn ($request) => $request->amount($this->activity->amount),
            )
            ->if(
                $this->activity->customData,
                fn ($request) => $request->customData($this->activity->customData),
            )
            ->if(
                $this->activity->customSessionId,
                fn ($request) => $request->customSessionId($this->activity->customSessionId),
            )
            ->if(
                $this->activity->dateTimeUtc,
                fn ($request) => $request->customDateTimeUtc($this->activity->dateTimeUtc),
            )
            ->send();
    }
}
