<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Rewards;

use R4nkt\LaravelR4nkt\Transporter\Concerns\AllowsPagination;

class ListRewards extends RewardRequest
{
    use AllowsPagination;

    protected string $method = 'GET';
}
