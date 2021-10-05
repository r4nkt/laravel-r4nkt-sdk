<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Concerns;

use Closure;
use R4nkt\LaravelR4nkt\Transporter\Criteria\CreateCriterion;
use R4nkt\LaravelR4nkt\Transporter\Criteria\DeleteCriterion;
use R4nkt\LaravelR4nkt\Transporter\Criteria\GetCriterion;
use R4nkt\LaravelR4nkt\Transporter\Criteria\ListCriteria;
use R4nkt\LaravelR4nkt\Transporter\Criteria\UpdateCriterion;

trait ManagesCriteria
{
    public function listCriteria(?Closure $callback = null)
    {
        $request = ListCriteria::build();

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function getCriterion(string $customId)
    {
        return GetCriterion::build()
            ->forCustomId($customId)
            ->send();
    }

    public function createCriterion(string $customId, string $name, string $customActionId, ?Closure $callback = null)
    {
        $request = CreateCriterion::build()
            ->customId($customId)
            ->name($name)
            ->customActionId($customActionId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function updateCriterion(string $customId, Closure $callback)
    {
        $request = UpdateCriterion::build()
            ->forCustomId($customId);

        if ($callback) {
            $callback($request);
        }

        return $request->send();
    }

    public function deleteCriterion(string $customId)
    {
        return DeleteCriterion::build()
            ->forCustomId($customId)
            ->send();
    }
}
