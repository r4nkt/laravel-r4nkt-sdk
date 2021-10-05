<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait PassesDateTimeUtc
{
    public function dateTimeUtc(string $dateTimeUtc)
    {
        return $this->withData(['date_time_utc' => $dateTimeUtc]);
    }
}
