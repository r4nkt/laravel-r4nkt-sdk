<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Transporter\Concerns;

class CreateCriteriaGroup extends CriteriaGroupRequest
{
    use Concerns\PassesCustomId;
    use Concerns\PassesName;
    use Concerns\PassesDescription;

    protected string $method = 'POST';

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
