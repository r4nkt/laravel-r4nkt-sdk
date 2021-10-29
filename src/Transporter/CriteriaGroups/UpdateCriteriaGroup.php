<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\CriteriaGroups;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Transporter\Concerns;

#[Requires('custom-id')]
class UpdateCriteriaGroup extends CriteriaGroupRequest
{
    use Concerns\HasCustomIdInPath;
    use Concerns\PassesCustomId;
    use Concerns\PassesName;
    use Concerns\PassesDescription;
    use Concerns\PassesConditions;

    protected string $method = 'PUT';

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
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
}
