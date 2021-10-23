<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Criteria;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class CriterionRequest extends R4nktRequest
{
    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addToPath('criteria');
    }
}
