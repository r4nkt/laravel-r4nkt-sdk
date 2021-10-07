<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomIdInPath;

class GetCriteriaGroup extends CriteriaGroupRequest
{
    use HasCustomIdInPath;

    protected string $method = 'GET';

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomId();
    }

    protected function finalizePath()
    {
        $this->setPath(self::BASE_PATH . '/' . $this->customId);
    }

    public function includeCriteria()
    {
        return $this->include('criteria');
    }

    public function includeCriteriaGroups()
    {
        return $this->include('criteria-groups');
    }
}
