<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Transporter\Concerns;

class ListCriteriaGroups extends CriteriaGroupRequest
{
    use Concerns\AllowsPagination;
    use Concerns\IncludesCriteria;
    use Concerns\IncludesNestedCriteriaGroups;

    protected string $method = 'GET';
}
