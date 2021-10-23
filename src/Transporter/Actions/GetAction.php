<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Actions;

use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomIdInPath;

class GetAction extends ActionRequest
{
    use HasCustomIdInPath;

    protected string $method = 'GET';

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomId();
    }

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
    }
}
