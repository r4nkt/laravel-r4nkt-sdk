<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Support\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class ActivityData extends DataTransferObject
{
    public string $customPlayerId;

    public string $customActionId;

    public ?int $amount;

    public ?string $customSessionId;

    public ?array $customData;

    public ?string $dateTimeUtc;
}
