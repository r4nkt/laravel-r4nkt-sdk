<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;

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
            throw IncompleteRequest::missingRequiredParameter('custom ID');
        }
    }
}
