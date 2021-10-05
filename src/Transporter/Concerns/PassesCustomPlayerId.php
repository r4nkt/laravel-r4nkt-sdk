<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait PassesCustomPlayerId
{
    public function customPlayerId(string $customPlayerId)
    {
        return $this->withData(['custom_player_id' => $customPlayerId]);
    }
}
