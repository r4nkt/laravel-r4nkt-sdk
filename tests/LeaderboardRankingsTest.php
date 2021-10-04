<?php

use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\LeaderboardRankings\ListLeaderboardRankings;

uses()->group('leaderboard-ranking');

afterEach(function () {
    clearLeaderboards();
    clearPlayers();
});

it('can list leaderboard rankings', function () {
    $customLeaderboardId = 'custom-leaderboard-id';
    LaravelR4nkt::createLeaderboard(
        $customLeaderboardId,
        'leaderboard-name',
        function ($request) {
            $request->custom(); // only one standard leaderboard per game allowed...for now...
        },
    );

    LaravelR4nkt::submitScore('homer', $customLeaderboardId, 20);
    LaravelR4nkt::submitScore('marge', $customLeaderboardId, 5);

    LaravelR4nkt::submitScore('bart', $customLeaderboardId, 10);
    LaravelR4nkt::submitScore('lisa', $customLeaderboardId, 10);
    LaravelR4nkt::submitScore('maggie', $customLeaderboardId, 10);

    LaravelR4nkt::submitScore('abe', $customLeaderboardId, 20);
    LaravelR4nkt::submitScore('mona', $customLeaderboardId, 5);

    $response = LaravelR4nkt::listLeaderboardRankings($customLeaderboardId);

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data')->count())->toBe(7);
    expect($response->collect('data'))->sequence(
        [
            'time_span' => 'all-time',
            'score' => 20,
            'rank' => 0,
            'custom_player_id' => 'homer',
        ],
        [
            'time_span' => 'all-time',
            'score' => 20,
            'rank' => 1,
            'custom_player_id' => 'abe',
        ],
        [
            'time_span' => 'all-time',
            'score' => 10,
            'rank' => 2,
            'custom_player_id' => 'bart',
        ],
        [
            'time_span' => 'all-time',
            'score' => 10,
            'rank' => 3,
            'custom_player_id' => 'lisa',
        ],
        [
            'time_span' => 'all-time',
            'score' => 10,
            'rank' => 4,
            'custom_player_id' => 'maggie',
        ],
        [
            'time_span' => 'all-time',
            'score' => 5,
            'rank' => 5,
            'custom_player_id' => 'marge',
        ],
        [
            'time_span' => 'all-time',
            'score' => 5,
            'rank' => 6,
            'custom_player_id' => 'mona',
        ],
    );
});

it('can paginate leaderboard rankings', function () {
    $customLeaderboardId = 'custom-leaderboard-id';
    LaravelR4nkt::createLeaderboard(
        $customLeaderboardId,
        'leaderboard-name',
        function ($request) {
            $request->custom(); // only one standard leaderboard per game allowed...for now...
        },
    );

    LaravelR4nkt::submitScore('homer', $customLeaderboardId, 20);
    LaravelR4nkt::submitScore('marge', $customLeaderboardId, 5);

    LaravelR4nkt::submitScore('bart', $customLeaderboardId, 10);
    LaravelR4nkt::submitScore('lisa', $customLeaderboardId, 10);
    LaravelR4nkt::submitScore('maggie', $customLeaderboardId, 10);

    LaravelR4nkt::submitScore('abe', $customLeaderboardId, 20);
    LaravelR4nkt::submitScore('mona', $customLeaderboardId, 5);

    $pageNumber = 2;
    $pageSize = 3;
    $response = LaravelR4nkt::listLeaderboardRankings($customLeaderboardId, function ($request) use ($pageNumber, $pageSize) {
        $request->pageNumber($pageNumber)
            ->pageSize($pageSize);
    });

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data'))->sequence(
        [
            'time_span' => 'all-time',
            'score' => 10,
            'rank' => 3,
            'custom_player_id' => 'lisa',
        ],
        [
            'time_span' => 'all-time',
            'score' => 10,
            'rank' => 4,
            'custom_player_id' => 'maggie',
        ],
        [
            'time_span' => 'all-time',
            'score' => 5,
            'rank' => 5,
            'custom_player_id' => 'marge',
        ],
    );
    expect($response->json('meta.current_page'))->toBe($pageNumber);
    expect($response->json('meta.from'))->toBe(4);
    expect($response->json('meta.to'))->toBe(6);
    expect($response->json('meta.last_page'))->toBe(3);
    expect($response->json('meta.per_page'))->toBe($pageSize);
    expect($response->json('meta.total'))->toBe(7);
});

it('cannot list leaderboard rankings without a custom leaderboard ID', function () {
    $request = ListLeaderboardRankings::build()
        ->send();
})->throws(IncompleteRequest::class);
