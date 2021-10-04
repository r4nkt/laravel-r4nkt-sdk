<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Transporter\Activities;

use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;

class ReportActivity extends ActivityRequest
{
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

    public function customPlayerId(string $customPlayerId)
    {
        return $this->withData(['custom_player_id' => $customPlayerId]);
    }

    public function customActionId(string $customActionId)
    {
        return $this->withData(['custom_action_id' => $customActionId]);
    }

    public function amount(int $amount)
    {
        return $this->withData(['amount' => $amount]);
    }

    public function customData(array $customData)
    {
        return $this->withData(['custom_data' => json_encode($customData)]);
    }

    public function customSessionId(string $customSessionId)
    {
        return $this->withData(['custom_session_id' => $customSessionId]);
    }

    public function dateTimeUtc(string $dateTimeUtc)
    {
        return $this->withData(['date_time_utc' => $dateTimeUtc]);
    }
}
