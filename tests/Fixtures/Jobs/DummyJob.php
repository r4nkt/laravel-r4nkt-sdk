<?php

namespace R4nkt\LaravelR4nkt\Tests\Fixtures\Jobs;

use R4nkt\LaravelR4nkt\Models\WebhookCall;

class DummyJob
{
    public function __construct(
        public WebhookCall $webhookCall,
    ) {
    }

    public function handle()
    {
        //
    }
}
