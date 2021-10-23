<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Transporter\Concerns;

class GetCriteriaGroup extends CriteriaGroupRequest
{
    use Concerns\HasCustomIdInPath;
    use Concerns\IncludesCriteria;
    use Concerns\IncludesNestedCriteriaGroups;

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
