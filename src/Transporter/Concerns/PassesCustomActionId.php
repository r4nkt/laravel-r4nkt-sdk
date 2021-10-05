<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait PassesCustomActionId
{
    public function customActionId(string $customActionId)
    {
        return $this->withData(['custom_action_id' => $customActionId]);
    }
}
