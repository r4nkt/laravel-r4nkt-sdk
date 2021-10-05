<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Achievements;

class CreateAchievement extends AchievementRequest
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

    public function isSecret(bool $isSecret)
    {
        return $this->withData(['is_secret' => $isSecret]);
    }

    public function customCriteriaGroupId(string $customCriteriaGroupId)
    {
        return $this->withData(['custom_criteria_group_id' => $customCriteriaGroupId]);
    }

    public function points(int $points)
    {
        return $this->withData(['points' => $points]);
    }

    public function customData(array $customData)
    {
        return $this->withData(['custom_data' => json_encode($customData)]);
    }
}
