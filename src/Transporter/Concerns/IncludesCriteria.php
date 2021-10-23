<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait IncludesCriteria
{
    public function includeCriteria()
    {
        return $this->include('criteria');
    }
}
