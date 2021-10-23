<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait IncludesNestedCriteriaGroups
{
    public function includeNestedCriteriaGroups()
    {
        return $this->include('criteria-groups');
    }
}
