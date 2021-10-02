<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Transporter\Leaderboards\CreateLeaderboard;
use R4nkt\LaravelR4nkt\Transporter\Leaderboards\DeleteLeaderboard;
use R4nkt\LaravelR4nkt\Transporter\Leaderboards\GetLeaderboard;
use R4nkt\LaravelR4nkt\Transporter\Leaderboards\ListLeaderboards;
use R4nkt\LaravelR4nkt\Transporter\Leaderboards\UpdateLeaderboard;

trait ManagesLeaderboards
{
    public function listLeaderboards(?Closure $callback = null)
    {
        $request = ListLeaderboards::build();

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function getLeaderboard(string $customId)
    {
        return GetLeaderboard::build()
            ->forCustomId($customId)
            ->send();
    }

    public function createLeaderboard(string $customId, string $name, ?Closure $callback = null)
    {
        $request = CreateLeaderboard::build()
            ->customId($customId)
            ->name($name);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function updateLeaderboard(string $customId, Closure $callback)
    {
        $request = UpdateLeaderboard::build()
            ->forCustomId($customId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function deleteLeaderboard(string $customId)
    {
        return DeleteLeaderboard::build()
            ->forCustomId($customId)
            ->send();
    }
}
