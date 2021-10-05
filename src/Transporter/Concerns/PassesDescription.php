<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait PassesDescription
{
    public function description(string $description)
    {
        return $this->withData(['description' => $description]);
    }
}
