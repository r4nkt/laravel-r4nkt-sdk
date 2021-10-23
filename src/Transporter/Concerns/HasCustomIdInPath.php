<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;

trait HasCustomIdInPath
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

    protected function addCustomIdToPath()
    {
        $this->addToPath($this->customId);
    }
}
