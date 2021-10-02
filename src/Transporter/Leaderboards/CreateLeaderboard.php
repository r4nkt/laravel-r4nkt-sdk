<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Leaderboards;

class CreateLeaderboard extends LeaderboardRequest
{
    protected string $method = 'POST';

    public function customId(string $customId)
    {
        return $this->withData(['custom_id' => $customId]);
    }

    public function name(string $name)
    {
        return $this->withData(['name' => $name]);
    }

    public function description(string $description)
    {
        return $this->withData(['description' => $description]);
    }

    public function customData(array $customData)
    {
        return $this->withData(['custom_data' => json_encode($customData)]);
    }

    public function type(string $type)
    {
        return $this->withData(['type' => $type]);
    }

    public function custom()
    {
        return $this->type('custom');
    }

    public function session()
    {
        return $this->type('session');
    }

    public function standard()
    {
        return $this->type('standard');
    }

    public function ordering(string $ordering)
    {
        return $this->withData(['ordering' => $ordering]);
    }

    public function largerIsBetter()
    {
        return $this->ordering('larger-is-better');
    }

    public function smallerIsBetter()
    {
        return $this->ordering('smaller-is-better');
    }

    public function scorePreference(string $scorePreference)
    {
        return $this->withData(['score_preference' => $scorePreference]);
    }

    public function preferHigher()
    {
        return $this->scorePreference('prefer-higher');
    }

    public function preferLower()
    {
        return $this->scorePreference('prefer-lower');
    }

    public function preferFirst()
    {
        return $this->scorePreference('prefer-first');
    }

    public function preferLast()
    {
        return $this->scorePreference('prefer-last');
    }

    public function customSessionId(string $customSessionId)
    {
        return $this->withData(['custom_session_id' => $customSessionId]);
    }
}
