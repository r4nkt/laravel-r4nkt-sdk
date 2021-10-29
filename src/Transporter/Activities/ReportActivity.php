<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Activities;

use R4nkt\LaravelR4nkt\Concerns\Requires;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\Concerns;

#[Requires('custom-player-id')]
#[Requires('custom-action-id')]
class ReportActivity extends ActivityRequest
{
    use Concerns\PassesCustomPlayerId;
    use Concerns\PassesCustomActionId;
    use Concerns\PassesCustomData;
    use Concerns\PassesCustomSessionId;
    use Concerns\PassesDateTimeUtc;

    protected string $method = 'POST';

    protected function guardAgainstMissingCustomPlayerId()
    {
        if (! isset($this->data['custom_player_id'])) {
            throw IncompleteRequest::missingRequiredParameter('custom player ID');
        }
    }

    protected function guardAgainstMissingCustomActionId()
    {
        if (! isset($this->data['custom_action_id'])) {
            throw IncompleteRequest::missingRequiredParameter('custom action ID');
        }
    }

    public function amount(int $amount)
    {
        return $this->withData(['amount' => $amount]);
    }
}
