<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Achievements;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class AchievementRequest extends R4nktRequest
{
    protected const BASE_PATH = 'achievements';

    protected string $path = self::BASE_PATH;
}
