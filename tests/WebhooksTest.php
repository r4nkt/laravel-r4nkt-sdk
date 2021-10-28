<?php

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Jobs\ProcessWebhook;
use R4nkt\LaravelR4nkt\Models\WebhookCall;
use R4nkt\LaravelR4nkt\Tests\Fixtures\Jobs\DummyJob;

uses()->group('webhook');

beforeEach(function () {
    Event::fake();

    Bus::fake();

    Route::r4nktWebhooks('r4nkt-webhooks');

    config(['r4nkt.signing_secret' => 'test_signing_secret']);
});

it('can handle a valid request', function () {
    $payload = getTestPayload();

    $headers = ['X-R4nkt-Signature' => determineR4nktSignature($payload)];

    $this
        ->postJson('r4nkt-webhooks', $payload, $headers)
        ->assertSuccessful();

    Bus::assertDispatched(ProcessWebhook::class, function (ProcessWebhook $job) {
        if (! $job->webhookCall instanceof WebhookCall) {
            return false;
        }
        if ($job->webhookCall->type() != 'badge-earned') {
            return false;
        }

        if ($job->webhookCall->dateTimeUtc() != '2021-10-27T03:45:27.612584Z') {
            return false;
        }

        return true;
    });
});

it('does nothing if a request has an invalid signature', function () {
    $payload = getTestPayload();

    $headers = ['X-R4nkt-Signature' => 'invalid_signature'];

    $this
        ->postJson('r4nkt-webhooks', $payload, $headers)
        ->assertStatus(Http::BAD_REQUEST);

    Event::assertNotDispatched('r4nkt-webhooks::badge-earned');

    Bus::assertNotDispatched(ProcessWebhook::class);
});

it('can properly process a webhook when a job is registered', function () {
    config(['r4nkt.jobs' => ['badge-earned' => DummyJob::class]]);

    $payload = getTestPayload();

    $webhookCall = WebhookCall::create([
        'name' => 'dummy-value', // originally: $config->name,
        'url' => 'dummy-value', // originally: $request->fullUrl(),
        'headers' => 'dummy-value', // originally: $headers,
        'payload' => $payload,
    ]);

    (new ProcessWebhook($webhookCall))->handle();

    Event::assertDispatched('r4nkt-webhooks::badge-earned', function ($event, $eventPayload) {
        if (! $eventPayload instanceof WebhookCall) {
            return false;
        }

        if ($eventPayload->type() != 'badge-earned') {
            return false;
        }

        if ($eventPayload->dateTimeUtc() != '2021-10-27T03:45:27.612584Z') {
            return false;
        }

        return true;
    });

    Bus::assertDispatched(DummyJob::class, function (DummyJob $job) {
        return $job->webhookCall->type() === 'badge-earned';
    });
});

it('can properly process a webhook when a job is not registered', function () {
    // config(['r4nkt.jobs' => ['badge-earned' => DummyJob::class]]);

    $payload = getTestPayload();

    $webhookCall = WebhookCall::create([
        'name' => 'dummy-value', // originally: $config->name,
        'url' => 'dummy-value', // originally: $request->fullUrl(),
        'headers' => 'dummy-value', // originally: $headers,
        'payload' => $payload,
    ]);

    (new ProcessWebhook($webhookCall))->handle();

    Event::assertDispatched('r4nkt-webhooks::badge-earned', function ($event, $eventPayload) {
        if (! $eventPayload instanceof WebhookCall) {
            return false;
        }

        if ($eventPayload->type() != 'badge-earned') {
            return false;
        }

        if ($eventPayload->dateTimeUtc() != '2021-10-27T03:45:27.612584Z') {
            return false;
        }

        return true;
    });

    Bus::assertNotDispatched(DummyJob::class);
});

function getTestPayload(): array
{
    return [
        'type' => 'badge-earned',
        'date_time_utc' => '2021-10-27T03:45:27.612584Z',
    ];
}

function determineR4nktSignature(array $payload): string
{
    $secret = config('r4nkt.signing_secret');

    return hash_hmac('sha256', json_encode($payload), $secret);
}
