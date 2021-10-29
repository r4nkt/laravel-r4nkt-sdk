<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Rewards;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomIdInPath;

#[Requires('custom-id')]
class GetReward extends RewardRequest
{
    use HasCustomIdInPath;

    protected string $method = 'GET';

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
    }
}
