<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter;

use Closure;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;
use JustSteveKing\Transporter\Request;

/**
 * @todo Make abstract...?  Can't use it alone...
 */
class R4nktRequest extends Request
{
    protected array $includes = [];

    public ?int $retryAfter = null;

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
        $this->setBaseUrl(config('r4nkt.base_url'));
    }

    public function send(): Response
    {
        $this->guardAgainstMissing();

        $this->finalizeIncludes();

        $this->finalizePath();

        return parent::send();
    }

    protected function finalizePath()
    {
        $gameId = config('r4nkt.game_id');

        $this->addToPath("games/{$gameId}");
    }

    protected function addToPath(string $path)
    {
        $this->setPath((string) Str::of($this->path())->finish('/')->append($path));
    }

    protected function include(string $include): static
    {
        $this->includes[] = $include;

        return $this;
    }

    protected function finalizeIncludes()
    {
        $includes = collect($this->includes)->filter();

        if ($includes->isEmpty()) {
            return;
        }

        $this->withQuery(['include' => $includes->implode(',')]);
    }

    protected function pushCustomHandlers(PendingRequest $request)
    {
        /** @todo Make this customizable/configurable. */
        $request->withMiddleware(
            Middleware::retry($this->retryDecider(), $this->retryDelay()),
        );
    }

    public function retryDecider()
    {
        /**
         * The variable, $_request, is not used, but is required. As such, it's
         * suppressed per:
         *  - https://psalm.dev/docs/running_psalm/issues/UnusedClosureParam
         */
        return function ($retries, Psr7Request $_request, Psr7Response $response = null, TransferException $exception = null) {
            // Limit the number of retries to 5
            if ($retries >= 5) {
                return false;
            }

            // Retry connection exceptions
            if ($exception instanceof ConnectException) {
                return true;
            }

            if ($response) {
                // Retry on rate limit hits
                if ($response->getStatusCode() == 429) {
                    $this->retryAfter = (int) $response->hasHeader('retry-after') ? (int) $response->getHeader('retry-after')[0] : null;

                    return true;
                }

                // Retry on server errors
                if ($response->getStatusCode() >= 500) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * delay 1s 2s 3s 4s 5s.
     */
    public function retryDelay()
    {
        return function ($numberOfRetries) {
            return 1000 * ($this->retryAfter ?: $numberOfRetries);
        };
    }

    /**
     * Inspiration: https://twitter.com/freekmurze/status/1452292850713088004
     */
    public function if(mixed $if, Closure $then, Closure $else = null)
    {
        value($if, $this)
            ? value($then, $this)
            : value($else, $this);

        return $this;
    }

    protected function guardAgainstMissing()
    {
        // ...
    }
}
