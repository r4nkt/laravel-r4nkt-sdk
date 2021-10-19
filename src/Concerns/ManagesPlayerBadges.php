<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Transporter\PlayerBadges\ListPlayerBadges;

trait ManagesPlayerBadges
{
    public function listPlayerBadges(string $customPlayerId, ?Closure $callback = null)
    {
        $request = ListPlayerBadges::build()
            ->forCustomPlayerId($customPlayerId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }
}
