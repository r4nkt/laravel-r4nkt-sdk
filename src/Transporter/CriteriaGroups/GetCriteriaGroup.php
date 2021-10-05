<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomId;

class GetCriteriaGroup extends CriteriaGroupRequest
{
    use HasCustomId;

    protected string $method = 'GET';

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomId();
    }

    protected function finalizePath()
    {
        $this->setPath(self::BASE_PATH . '/' . $this->customId);
    }
}
