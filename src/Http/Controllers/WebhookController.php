<?php

namespace R4nkt\LaravelR4nkt\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use R4nkt\LaravelR4nkt\Jobs\ProcessWebhook;
use R4nkt\LaravelR4nkt\Models\WebhookCall;
use Spatie\WebhookClient\Exceptions\InvalidWebhookSignature;
use Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;
use Spatie\WebhookClient\WebhookProcessor;
use Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $webhookConfig = new WebhookConfig([
                'name' => 'r4nkt-webhook',
                'signing_secret' => config('r4nkt.signing_secret'),
                'signature_header_name' => 'X-R4nkt-Signature',
                'signature_validator' => DefaultSignatureValidator::class,
                'webhook_profile' => ProcessEverythingWebhookProfile::class,
                'webhook_response' => DefaultRespondsTo::class,
                'webhook_model' => WebhookCall::class,
                'process_webhook_job' => ProcessWebhook::class,
            ]);

            (new WebhookProcessor($request, $webhookConfig))->process();
        } catch (InvalidWebhookSignature $e) {
            return response()->json(['error' => 'invalid webhook signature.'], 400);
        }
    }
}
