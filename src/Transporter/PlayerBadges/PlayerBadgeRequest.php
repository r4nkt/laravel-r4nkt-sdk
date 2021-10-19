<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\PlayerBadges;

use Illuminate\Support\Str;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class PlayerBadgeRequest extends R4nktRequest
{
    protected const BASE_PATH = 'players/{player-id}/badges';

    protected string $path = self::BASE_PATH;

    protected string $customPlayerId;

    public function forCustomPlayerId(string $customPlayerId)
    {
        $this->customPlayerId = $customPlayerId;

        return $this;
    }

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomPlayerId();
    }

    protected function guardAgainstMissingCustomPlayerId()
    {
        if (! isset($this->customPlayerId)) {
            throw IncompleteRequest::missingRequiredParameter('custom player ID');
        }
    }

    protected function finalizePath()
    {
        $this->setPath((string) Str::of(self::BASE_PATH)->replace('{player-id}', $this->customPlayerId));
    }
}
