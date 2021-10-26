<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Jobs\ReportActivity as ReportActivityJob;
use R4nkt\LaravelR4nkt\Support\Dtos\ActivityData;
use R4nkt\LaravelR4nkt\Transporter\Activities\ReportActivity;

trait ManagesActivities
{
    public function reportActivity(string $customPlayerId, string $customActionId, int $amount = 1, ?Closure $callback = null)
    {
        $request = ReportActivity::build()
            ->customPlayerId($customPlayerId)
            ->customActionId($customActionId)
            ->amount($amount);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function queueActivityReport(
        string $customPlayerId,
        string $customActionId,
        ?int $amount = null,
        ?string $customSessionId = null,
        ?array $customData = null,
        ?string $dateTimeUtc = null,
    ) {
        ReportActivityJob::dispatch(new ActivityData(
            customPlayerId: $customPlayerId,
            customActionId: $customActionId,
            amount: $amount,
            customSessionId: $customSessionId,
            customData: $customData,
            dateTimeUtc: $dateTimeUtc,
        ));
    }
}
