<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Rewards;

use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomId;

class UpdateReward extends RewardRequest
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
}
