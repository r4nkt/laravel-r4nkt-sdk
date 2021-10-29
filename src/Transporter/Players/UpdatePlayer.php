<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Players;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Transporter\Concerns;

#[Requires('custom-id')]
class UpdatePlayer extends PlayerRequest
{
    use Concerns\HasCustomIdInPath;
    use Concerns\PassesCustomId;
    use Concerns\PassesCustomData;

    protected string $method = 'PUT';

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
    }

    public function timeZone(string $timeZone)
    {
        return $this->withData(['time_zone' => $timeZone]);
    }
}
