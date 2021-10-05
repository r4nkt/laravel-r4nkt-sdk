<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Players;

use R4nkt\LaravelR4nkt\Transporter\Concerns;

class CreatePlayer extends PlayerRequest
{
    use Concerns\PassesCustomId;
    use Concerns\PassesCustomData;

    protected string $method = 'POST';

    public function timeZone(string $timeZone)
    {
        return $this->withData(['time_zone' => $timeZone]);
    }
}
