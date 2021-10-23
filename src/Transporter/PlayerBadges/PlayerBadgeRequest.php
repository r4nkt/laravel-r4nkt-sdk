<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\PlayerBadges;

use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class PlayerBadgeRequest extends R4nktRequest
{
    protected string $customPlayerId;

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
        parent::finalizePath();

        $this->addToPath("players/{$this->customPlayerId}/badges");
    }

    public function forCustomPlayerId(string $customPlayerId)
    {
        $this->customPlayerId = $customPlayerId;

        return $this;
    }
}
