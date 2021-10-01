<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Leaderboards;

use Illuminate\Http\Client\PendingRequest;
use JustSteveKing\Transporter\Request;

class LeaderboardRequest extends Request
{
    protected string $method = 'GET';
    protected string $baseUrl = 'https://api.r4nkt.com/v1';
    protected string $path = '';

    protected array $data = [
        'completed' => true,
    ];

    protected function withRequest(PendingRequest $request): void
    {
        parent::withRequest($request);

        // $request->withToken(config('jsonplaceholder.api.token'));
    }
}
