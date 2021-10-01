<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Actions;

class DeleteAction extends ActionRequest
{
    protected string $method = 'DELETE';

    public function customId(string $customId)
    {
        return $this->setPath(self::BASE_PATH . '/' . $customId);
    }
}
