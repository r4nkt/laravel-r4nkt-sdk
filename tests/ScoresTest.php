<?php

use JustSteveKing\StatusCode\Http;

uses()->group('score');

afterEach(function () {
    clearPlayers();
    clearLeaderboards();
});

it('can submit an score', function () {
    $customPlayerId = 'test-player-id';
    expect(
        LaravelR4nkt::createPlayer(
            $customPlayerId,
        )->status()
    )->toBe(Http::CREATED);

    $customLeaderboardId = 'test-leaderboard-id';
    $leaderboardName = 'test-leaderboard-name';
    expect(
        LaravelR4nkt::createLeaderboard(
            $customLeaderboardId,
            $leaderboardName,
            function ($request) {
                $request->custom();
            }
        )->status()
    )->toBe(Http::CREATED);

    $score = 1234;
    $response = LaravelR4nkt::submitScore(
        $customPlayerId,
        $customLeaderboardId,
        $score,
    );

    expect($response->status())->toBe(Http::CREATED);
    expect($response->json('data.uuid'))->toBeString();
    expect($response->json('data.custom_player_id'))->toBe($customPlayerId);
    expect($response->json('data.custom_leaderboard_id'))->toBe($customLeaderboardId);
    expect($response->json('data.score'))->toBe($score);
    expect($response->json('data.date_time_utc'))->toBeString();
    expect($response->json('data.improved_time_spans'))->toEqualCanonicalizing([
        'all-time',
        'daily',
        'monthly',
        'weekly',
        'yearly',
    ]);
});
