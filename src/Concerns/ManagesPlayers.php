<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Transporter\Players\CreatePlayer;
use R4nkt\LaravelR4nkt\Transporter\Players\DeletePlayer;
use R4nkt\LaravelR4nkt\Transporter\Players\GetPlayer;
use R4nkt\LaravelR4nkt\Transporter\Players\ListPlayers;
use R4nkt\LaravelR4nkt\Transporter\Players\UpdatePlayer;

trait ManagesPlayers
{
    public function listPlayers(?Closure $callback = null)
    {
        $request = ListPlayers::build();

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function getPlayer(string $customId)
    {
        return GetPlayer::build()
            ->forCustomId($customId)
            ->send();
    }

    public function createPlayer(string $customId, ?Closure $callback = null)
    {
        $request = CreatePlayer::build()
            ->customId($customId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function updatePlayer(string $customId, Closure $callback)
    {
        $request = UpdatePlayer::build()
            ->forCustomId($customId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function deletePlayer(string $customId)
    {
        return DeletePlayer::build()
            ->forCustomId($customId)
            ->send();
    }
}
