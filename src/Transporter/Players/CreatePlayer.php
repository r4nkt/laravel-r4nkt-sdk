<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Players;

class CreatePlayer extends PlayerRequest
{
    protected string $method = 'POST';

    public function customId(string $customId)
    {
        return $this->withData(['custom_id' => $customId]);
    }

    public function timeZone(string $timeZone)
    {
        return $this->withData(['time_zone' => $timeZone]);
    }

    public function description(string $description)
    {
        return $this->withData(['description' => $description]);
    }

    public function customData(array $customData)
    {
        return $this->withData(['custom_data' => json_encode($customData)]);
    }
}
