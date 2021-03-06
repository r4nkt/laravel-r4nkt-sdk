<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Achievements;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Transporter\Concerns;

#[Requires('custom-id')]
class UpdateAchievement extends AchievementRequest
{
    use Concerns\HasCustomIdInPath;
    use Concerns\PassesCustomId;
    use Concerns\PassesName;
    use Concerns\PassesDescription;
    use Concerns\PassesCustomData;

    protected string $method = 'PUT';

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
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
}
