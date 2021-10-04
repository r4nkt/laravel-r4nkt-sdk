<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Rewards;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class RewardRequest extends R4nktRequest
{
    protected const BASE_PATH = 'rewards';

    protected string $path = self::BASE_PATH;
}
