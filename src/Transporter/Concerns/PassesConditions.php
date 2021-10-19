<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait PassesConditions
{
    public function conditions(array $conditions)
    {
        return $this->withData(['conditions' => $conditions]);
    }
}
