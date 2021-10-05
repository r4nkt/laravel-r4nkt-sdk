<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Transporter\CriteriaGroups\CreateCriteriaGroup;
use R4nkt\LaravelR4nkt\Transporter\CriteriaGroups\DeleteCriteriaGroup;
use R4nkt\LaravelR4nkt\Transporter\CriteriaGroups\GetCriteriaGroup;
use R4nkt\LaravelR4nkt\Transporter\CriteriaGroups\ListCriteriaGroups;
use R4nkt\LaravelR4nkt\Transporter\CriteriaGroups\UpdateCriteriaGroup;

trait ManagesCriteriaGroups
{
    public function listCriteriaGroups(?Closure $callback = null)
    {
        $request = ListCriteriaGroups::build();

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function getCriteriaGroup(string $customId)
    {
        return GetCriteriaGroup::build()
            ->forCustomId($customId)
            ->send();
    }

    public function createCriteriaGroup(string $customId, string $name, ?Closure $callback = null)
    {
        $request = CreateCriteriaGroup::build()
            ->customId($customId)
            ->name($name);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function updateCriteriaGroup(string $customId, Closure $callback)
    {
        $request = UpdateCriteriaGroup::build()
            ->forCustomId($customId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function deleteCriteriaGroup(string $customId)
    {
        return DeleteCriteriaGroup::build()
            ->forCustomId($customId)
            ->send();
    }
}
