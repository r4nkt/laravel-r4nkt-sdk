<?php

use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\PlayerBadges\ListPlayerBadges;

uses()->group('player-badge');

it('cannot get player badges without a custom player id', function () {
    ListPlayerBadges::build()
        ->send();
})->throws(IncompleteRequest::class);
