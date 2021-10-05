<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class CriteriaGroupRequest extends R4nktRequest
{
    protected const BASE_PATH = 'criteria-groups';

    protected string $path = self::BASE_PATH;
}
