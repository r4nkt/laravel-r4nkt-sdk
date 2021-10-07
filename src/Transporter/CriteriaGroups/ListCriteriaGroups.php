<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Transporter\Concerns\AllowsPagination;

class ListCriteriaGroups extends CriteriaGroupRequest
{
    use AllowsPagination;

    protected string $method = 'GET';

    public function includeCriteria()
    {
        return $this->include('criteria');
    }

    public function includeCriteriaGroups()
    {
        return $this->include('criteria-groups');
    }
}
