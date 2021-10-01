<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait HasCustomId
{
    protected string $customId;

    public function forCustomId(string $customId)
    {
        $this->customId = $customId;

        return $this;
    }

    protected function guardAgainstMissingCustomId()
    {
        if (! isset($this->customId)) {
            throw new \Exception('missing required custom ID');
        }
    }
}
