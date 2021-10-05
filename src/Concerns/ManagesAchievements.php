<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Transporter\Achievements\CreateAchievement;
use R4nkt\LaravelR4nkt\Transporter\Achievements\DeleteAchievement;
use R4nkt\LaravelR4nkt\Transporter\Achievements\GetAchievement;
use R4nkt\LaravelR4nkt\Transporter\Achievements\ListAchievements;
use R4nkt\LaravelR4nkt\Transporter\Achievements\UpdateAchievement;

trait ManagesAchievements
{
    public function listAchievements(?Closure $callback = null)
    {
        $request = ListAchievements::build();

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function getAchievement(string $customId)
    {
        return GetAchievement::build()
            ->forCustomId($customId)
            ->send();
    }

    public function createAchievement(string $customId, string $name, ?Closure $callback = null)
    {
        $request = CreateAchievement::build()
            ->customId($customId)
            ->name($name);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function updateAchievement(string $customId, Closure $callback)
    {
        $request = UpdateAchievement::build()
            ->forCustomId($customId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function deleteAchievement(string $customId)
    {
        return DeleteAchievement::build()
            ->forCustomId($customId)
            ->send();
    }
}
