<?php

namespace R4nkt\LaravelR4nkt\Models;

use Spatie\WebhookClient\Models\WebhookCall as ClientWebhookCall;

class WebhookCall extends ClientWebhookCall
{
    public function type(): string
    {
        return $this->payload['type'];
    }

    public function dateTimeUtc(): string
    {
        return $this->payload['date_time_utc'];
    }
}
