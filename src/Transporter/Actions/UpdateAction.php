<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Actions;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Transporter\Concerns;

#[Requires('custom-id')]
class UpdateAction extends ActionRequest
{
    use Concerns\HasCustomIdInPath;
    use Concerns\PassesCustomId;
    use Concerns\PassesName;
    use Concerns\PassesDescription;
    use Concerns\PassesCustomData;

    protected string $method = 'PUT';

    protected function finalizePath()
    {
        parent::finalizePath();

        $this->addCustomIdToPath();
    }
}
