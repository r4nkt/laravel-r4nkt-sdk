<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Achievements;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomIdInPath;

#[Requires('custom-id')]
class GetAchievement extends AchievementRequest
{
    use HasCustomIdInPath;

    protected string $method = 'GET';

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
    }
}
