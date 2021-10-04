<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Transporter\Rewards\CreateReward;
use R4nkt\LaravelR4nkt\Transporter\Rewards\DeleteReward;
use R4nkt\LaravelR4nkt\Transporter\Rewards\GetReward;
use R4nkt\LaravelR4nkt\Transporter\Rewards\ListRewards;
use R4nkt\LaravelR4nkt\Transporter\Rewards\UpdateReward;

trait ManagesRewards
{
    public function listRewards(?Closure $callback = null)
    {
        $request = ListRewards::build();

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function getReward(string $customId)
    {
        return GetReward::build()
            ->forCustomId($customId)
            ->send();
    }

    public function createReward(string $customId, string $name, ?Closure $callback = null)
    {
        $request = CreateReward::build()
            ->customId($customId)
            ->name($name);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function updateReward(string $customId, Closure $callback)
    {
        $request = UpdateReward::build()
            ->forCustomId($customId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function deleteReward(string $customId)
    {
        return DeleteReward::build()
            ->forCustomId($customId)
            ->send();
    }
}
