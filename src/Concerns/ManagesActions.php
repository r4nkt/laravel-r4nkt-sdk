<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Transporter\Actions\CreateAction;
use R4nkt\LaravelR4nkt\Transporter\Actions\DeleteAction;
use R4nkt\LaravelR4nkt\Transporter\Actions\GetAction;
use R4nkt\LaravelR4nkt\Transporter\Actions\ListActions;
use R4nkt\LaravelR4nkt\Transporter\Actions\UpdateAction;

trait ManagesActions
{
    public function listActions(?Closure $callback = null)
    {
        $request = ListActions::build();

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function getAction(string $customId)
    {
        return GetAction::build()
            ->forCustomId($customId)
            ->send();
    }

    public function createAction(string $customId, string $name, ?Closure $callback = null)
    {
        $request = CreateAction::build()
            ->customId($customId)
            ->name($name);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function updateAction(string $customId, Closure $callback)
    {
        $request = UpdateAction::build()
            ->forCustomId($customId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function deleteAction(string $customId)
    {
        return DeleteAction::build()
            ->forCustomId($customId)
            ->send();
    }
}
