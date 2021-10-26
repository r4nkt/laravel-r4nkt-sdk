<?php

declare(strict_types=1);

namespace R4nkt\LaravelR4nkt\Support\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class ScoreSubmissionData extends DataTransferObject
{
    public string $customPlayerId;

    public string $customLeaderboardId;

    public int $score;

    public ?string $dateTimeUtc;
}
