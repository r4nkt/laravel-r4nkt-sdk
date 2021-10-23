<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Activities;

use R4nkt\LaravelR4nkt\Transporter\R4nktRequest;

class ActivityRequest extends R4nktRequest
{
    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addToPath('activities');
    }
}
