<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Leaderboards;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class LeaderboardRequest extends R4nktRequest
{
    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addToPath('leaderboards');
    }
}
