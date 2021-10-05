<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Criteria;

use R4nkt\LaravelR4nkt\Transporter\Concerns;

class CreateCriterion extends CriterionRequest
{
    use Concerns\PassesCustomId;
    use Concerns\PassesCustomActionId;
    use Concerns\PassesName;
    use Concerns\PassesDescription;
    use Concerns\PassesConditions;

    protected string $method = 'POST';

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

    public function rule(string $rule)
    {
        return $this->withData(['rule' => $rule]);
    }

    public function streak(string $streak)
    {
        return $this->withData(['streak' => $streak]);
    }
}
