<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Activities;

use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\Concerns;

class ReportActivity extends ActivityRequest
{
    use Concerns\PassesCustomPlayerId;
    use Concerns\PassesCustomActionId;
    use Concerns\PassesCustomData;
    use Concerns\PassesCustomSessionId;
    use Concerns\PassesDateTimeUtc;

    protected string $method = 'POST';

    protected function guardAgainstMissing()
    {
        $this->guardAgainstMissingCustomPlayerId();
        $this->guardAgainstMissingCustomActionId();
    }

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
