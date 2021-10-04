<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
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
}
