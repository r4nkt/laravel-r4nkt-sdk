<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Transporter\Concerns\HasCustomId;

class UpdateCriteriaGroup extends CriteriaGroupRequest
{
    use HasCustomId;

    protected string $method = 'PUT';

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomId();
    }

    protected function finalizePath()
    {
        $this->setPath(self::BASE_PATH . '/' . $this->customId);
    }

    public function customId(string $customId)
    {
        return $this->withData(['custom_id' => $customId]);
    }

    public function name(string $name)
    {
        return $this->withData(['name' => $name]);
    }

    public function description(string $description)
    {
        return $this->withData(['description' => $description]);
    }

    public function operator(string $operator)
    {
        return $this->withData(['operator' => $operator]);
    }

    public function and()
    {
        return $this->operator('and');
    }

    public function or()
    {
        return $this->operator('or');
    }

    public function xor()
    {
        return $this->operator('xor');
    }

    public function conditions(array $conditions)
    {
        return $this->withData(['conditions' => json_encode($conditions)]);
    }
}
