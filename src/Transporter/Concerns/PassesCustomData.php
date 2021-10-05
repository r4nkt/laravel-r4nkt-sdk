<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Concerns;

trait PassesCustomData
{
    public function customData(array $customData)
    {
        return $this->withData(['custom_data' => json_encode($customData)]);
    }
}
