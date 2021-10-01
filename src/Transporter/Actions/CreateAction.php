<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Actions;

class CreateAction extends ActionRequest
{
    protected string $method = 'POST';

    public function customId(string $customId)
    {
        return $this->withData(['custom_id' => $customId]);
    }

    public function name(string $name)
    {
        return $this->withData(['name' => $name]);
    }
}
