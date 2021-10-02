<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Players;

use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomId;

class UpdatePlayer extends PlayerRequest
{
    use HasCustomId;

    protected string $method = 'PUT';

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomId();
    }

    protected function finalizePath()
    {
        $this->setPath(self::BASE_PATH . '/' . $this->customId);
    }

    public function customId(string $customId)
    {
        return $this->withData(['custom_id' => $customId]);
    }

    public function timeZone(string $timeZone)
    {
        return $this->withData(['time_zone' => $timeZone]);
    }

    public function customData(array $customData)
    {
        return $this->withData(['custom_data' => json_encode($customData)]);
    }
}
