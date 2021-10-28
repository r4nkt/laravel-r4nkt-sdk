<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Jobs;

use R4nkt\LaravelR4nkt\Exceptions\WebhookFailed;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhook extends SpatieProcessWebhookJob
{
    public function handle()
    {
        $type = $this->webhookCall->type();

        event("r4nkt-webhooks::{$type}", $this->webhookCall);

        $jobClass = $this->determineJobClass($type);

        if ($jobClass === '') {
            return;
        }

        if (! class_exists($jobClass)) {
            throw WebhookFailed::jobClassDoesNotExist($jobClass, $this->webhookCall);
        }

        dispatch(new $jobClass($this->webhookCall));
    }

    protected function determineJobClass(string $type): string
    {
        return config("r4nkt.jobs.{$type}", '');
    }
}
