<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Achievements;

use R4nkt\LaravelR4nkt\Transporter\Concerns\AllowsPagination;

class ListAchievements extends AchievementRequest
{
    use AllowsPagination;

    protected string $method = 'GET';

    protected function secrets(string $filter)
    {
        $this->withQuery(['filter' => ['secret' => $filter]]);

        return $this;
    }

    public function withSecrets()
    {
        return $this->secrets('with');
    }

    public function withoutSecrets()
    {
        return $this->secrets('without');
    }

    public function onlySecrets()
    {
        return $this->secrets('only');
    }
}
