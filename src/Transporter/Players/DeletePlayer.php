<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Players;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomIdInPath;

#[Requires('custom-id')]
class DeletePlayer extends PlayerRequest
{
    use HasCustomIdInPath;

    protected string $method = 'DELETE';

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
    }
}
