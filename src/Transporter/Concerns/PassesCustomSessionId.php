<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait PassesCustomSessionId
{
    public function customSessionId(string $customSessionId)
    {
        return $this->withData(['custom_session_id' => $customSessionId]);
    }
}
