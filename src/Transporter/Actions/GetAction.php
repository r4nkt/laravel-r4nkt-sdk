<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Actions;

class GetAction extends ActionRequest
{
    protected string $method = 'GET';

    public function customId(string $customId)
    {
        return $this->setPath(self::BASE_PATH . '/' . $customId);
    }
}
