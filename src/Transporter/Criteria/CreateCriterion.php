<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Criteria;

class CreateCriterion extends CriterionRequest
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

    public function description(string $description)
    {
        return $this->withData(['description' => $description]);
    }

    public function type(string $type)
    {
        return $this->withData(['type' => $type]);
    }

    public function sum()
    {
        return $this->type('sum');
    }

    public function amount()
    {
        return $this->type('amount');
    }

    public function average()
    {
        return $this->type('average');
    }

    public function customActionId(string $customActionId)
    {
        return $this->withData(['custom_action_id' => $customActionId]);
    }

    public function conditions(array $conditions)
    {
        return $this->withData(['conditions' => json_encode($conditions)]);
    }

    public function rule(string $rule)
    {
        return $this->withData(['rule' => $rule]);
    }

    public function streak(string $streak)
    {
        return $this->withData(['streak' => $streak]);
    }
}
