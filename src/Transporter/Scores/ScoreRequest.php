<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Scores;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class ScoreRequest extends R4nktRequest
{
    protected const BASE_PATH = 'scores';

    protected string $path = self::BASE_PATH;
}
