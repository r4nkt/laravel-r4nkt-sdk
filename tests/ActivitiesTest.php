<?php

use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\Activities\ReportActivity;

uses()->group('activity');

afterEach(function () {
    clearPlayers();
    clearActions();
});

it('cannot report an activity without a custom player id', function () {
    ReportActivity::build()
        ->customActionId('test-action-id')
        ->send();
})->throws(IncompleteRequest::class);

it('cannot report an activity without a custom action id', function () {
    ReportActivity::build()
        ->customPlayerId('test-player-id')
        ->send();
})->throws(IncompleteRequest::class);

it('can report an activity', function () {
    $customActionId = 'test-action-id';
    expect(
        LaravelR4nkt::createAction(
            $customActionId,
            'test-action-name',
        )->status()
    )->toBe(Http::CREATED);

    $customPlayerId = 'test-player-id';
    $amount = 1234;
    $customData = ['foo' => 'bar'];
    $customSessionId = 'test-custom-session-id';
    $response = LaravelR4nkt::reportActivity(
        $customPlayerId,
        $customActionId,
        $amount,
        function ($request) use ($customData, $customSessionId) {
            $request->customData($customData)
                ->customSessionId($customSessionId);
        },
    );

    expect($response->status())->toBe(Http::CREATED);
    expect($response->json('data.uuid'))->toBeString();
    expect($response->json('data.custom_player_id'))->toBe($customPlayerId);
    expect($response->json('data.custom_action_id'))->toBe($customActionId);
    expect($response->json('data.amount'))->toBe($amount);
    expect($response->json('data.date_time_utc'))->toBeString();
    expect($response->json('data.custom_data'))->toBe($customData);
    expect($response->json('data.custom_session_id'))->toBe($customSessionId);
});
