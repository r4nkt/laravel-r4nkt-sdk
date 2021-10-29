<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Transporter\Concerns;

#[Requires('custom-id')]
class GetCriteriaGroup extends CriteriaGroupRequest
{
    use Concerns\HasCustomIdInPath;
    use Concerns\IncludesCriteria;
    use Concerns\IncludesNestedCriteriaGroups;

    protected string $method = 'GET';

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
    }
}
