<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use JustSteveKing\Transporter\Request;

/**
 * @todo Make abstract...?  Can't use it alone...
 */
class R4nktRequest extends Request
{
    protected const BASE_URL = 'https://api.r4nkt.com/v1/games/';

    // protected string $method = 'GET';
    // protected string $baseUrl = 'https://api.r4nkt.com/v1/games/{game_id}';
    // protected string $path = '';

    // protected array $data = [
    //     'completed' => true,
    // ];

    public function send(): Response
    {
        $this->guardAgainstMissing();

        $this->finalizePath();

        return parent::send();
    }

    protected function withRequest(PendingRequest $request): void
    {
        $this->configureBaseUrl();

        $this->pushCustomHandlers($request);

        $request->withToken(config('r4nkt.api_token'))
            ->acceptJson()
            ->asJson();
    }

    protected function configureBaseUrl()
    {
        $gameId = config('r4nkt.game_id');

        $this->setBaseUrl(self::BASE_URL . $gameId);
    }

    protected function pushCustomHandlers(PendingRequest $request)
    {
        /** @todo ... */
        // $request->pushHandlers();
    }

    protected function guardAgainstMissing()
    {
        // ...
    }

    protected function finalizePath()
    {
        // ...
    }
}
