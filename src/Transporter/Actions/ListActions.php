<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Actions;

use R4nkt\LaravelR4nkt\Transporter\Concerns\AllowsPagination;

class ListActions extends ActionRequest
{
    use AllowsPagination;

    protected string $method = 'GET';
}
