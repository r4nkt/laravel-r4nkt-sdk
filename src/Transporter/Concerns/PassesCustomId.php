<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait PassesCustomId
{
    public function customId(string $customId)
    {
        return $this->withData(['custom_id' => $customId]);
    }
}
