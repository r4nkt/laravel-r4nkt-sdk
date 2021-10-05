<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Players;

use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomIdInPath;

class DeletePlayer extends PlayerRequest
{
    use HasCustomIdInPath;

    protected string $method = 'DELETE';

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomId();
    }

    protected function finalizePath()
    {
        $this->setPath(self::BASE_PATH . '/' . $this->customId);
    }
}
