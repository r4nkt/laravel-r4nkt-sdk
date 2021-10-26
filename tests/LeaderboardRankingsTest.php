<?php

use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\LeaderboardRankings\ListLeaderboardRankings;

uses()->group('leaderboard-ranking');

beforeEach(function () {
    /**
     * Create two different leaderboards:
     *  - larger-is-better
     *  - smaller-is-better
     */
    expect(
        LaravelR4nkt::createLeaderboard(
            'custom.leaderboard.larger',
            'custom.leaderboard.larger',
            function ($request) {
                $request->custom();
            },
        )->status()
    )->toBe(Http::CREATED);

    expect(
        LaravelR4nkt::createLeaderboard(
            'custom.leaderboard.smaller',
            'custom.leaderboard.smaller',
            function ($request) {
                $request->custom()
                    ->smallerIsBetter();
            },
        )->status()
    )->toBe(Http::CREATED);

    /**
     * Now populate the two different leaderboards
     *  - same order
     *  - same people,
     *  - same scores
     */
    LaravelR4nkt::queueScoreSubmission('homer', 'custom.leaderboard.larger', 20);
    LaravelR4nkt::queueScoreSubmission('marge', 'custom.leaderboard.larger', 5);

    LaravelR4nkt::queueScoreSubmission('bart', 'custom.leaderboard.larger', 10);
    LaravelR4nkt::queueScoreSubmission('lisa', 'custom.leaderboard.larger', 10);
    LaravelR4nkt::queueScoreSubmission('maggie', 'custom.leaderboard.larger', 10);

    LaravelR4nkt::queueScoreSubmission('abe', 'custom.leaderboard.larger', 20);
    LaravelR4nkt::queueScoreSubmission('mona', 'custom.leaderboard.larger', 5);

    LaravelR4nkt::queueScoreSubmission('homer', 'custom.leaderboard.smaller', 20);
    LaravelR4nkt::queueScoreSubmission('marge', 'custom.leaderboard.smaller', 5);

    LaravelR4nkt::queueScoreSubmission('bart', 'custom.leaderboard.smaller', 10);
    LaravelR4nkt::queueScoreSubmission('lisa', 'custom.leaderboard.smaller', 10);
    LaravelR4nkt::queueScoreSubmission('maggie', 'custom.leaderboard.smaller', 10);

    LaravelR4nkt::queueScoreSubmission('abe', 'custom.leaderboard.smaller', 20);
    LaravelR4nkt::queueScoreSubmission('mona', 'custom.leaderboard.smaller', 5);
});

afterEach(function () {
    clearLeaderboards();
    clearPlayers();
});

it('can list larger-is-better leaderboard rankings', function () {
    $response = LaravelR4nkt::listLeaderboardRankings('custom.leaderboard.larger');

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data'))
        ->toHaveCount(7)
        ->sequence(
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

it('can paginate larger-is-better leaderboard rankings', function () {
    $pageNumber = 2;
    $pageSize = 3;

    $response = LaravelR4nkt::listLeaderboardRankings('custom.leaderboard.larger', function ($request) use ($pageNumber, $pageSize) {
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
    expect($response->json('meta'))
        ->toMatchArray([
            'current_page' => $pageNumber,
            'from' => 4,
            'to' => 6,
            'last_page' => 3,
            'per_page' => $pageSize,
            'total' => 7,
        ]);
});

it('can list smaller-is-better leaderboard rankings', function () {
    $response = LaravelR4nkt::listLeaderboardRankings('custom.leaderboard.smaller');

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data'))
        ->toHaveCount(7)
        ->sequence(
            [
                'time_span' => 'all-time',
                'score' => 5,
                'rank' => 0,
                'custom_player_id' => 'marge',
            ],
            [
                'time_span' => 'all-time',
                'score' => 5,
                'rank' => 1,
                'custom_player_id' => 'mona',
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
                'score' => 20,
                'rank' => 5,
                'custom_player_id' => 'homer',
            ],
            [
                'time_span' => 'all-time',
                'score' => 20,
                'rank' => 6,
                'custom_player_id' => 'abe',
            ],
        );
});

it('can paginate smaller-is-better leaderboard rankings', function () {
    $pageNumber = 2;
    $pageSize = 3;

    $response = LaravelR4nkt::listLeaderboardRankings('custom.leaderboard.smaller', function ($request) use ($pageNumber, $pageSize) {
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
            'score' => 20,
            'rank' => 5,
            'custom_player_id' => 'homer',
        ],
    );
    expect($response->json('meta'))
        ->toMatchArray([
            'current_page' => $pageNumber,
            'from' => 4,
            'to' => 6,
            'last_page' => 3,
            'per_page' => $pageSize,
            'total' => 7,
        ]);
});

it('cannot list leaderboard rankings without a custom leaderboard ID', function () {
    $request = ListLeaderboardRankings::build()
        ->send();
})->throws(IncompleteRequest::class);
