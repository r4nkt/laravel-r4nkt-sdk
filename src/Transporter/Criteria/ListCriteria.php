<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Criteria;

use R4nkt\LaravelR4nkt\Transporter\Concerns\AllowsPagination;

class ListCriteria extends CriterionRequest
{
    use AllowsPagination;

    protected string $method = 'GET';
}
