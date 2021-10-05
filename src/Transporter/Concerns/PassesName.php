<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait PassesName
{
    public function name(string $name)
    {
        return $this->withData(['name' => $name]);
    }
}
