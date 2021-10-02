<?php

use JustSteveKing\StatusCode\Http;

uses()->group('leaderboard');

afterEach(function () {
    clearLeaderboards();
});

it('can create an leaderboard', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';
    $description = 'some-description';
    $customData = ['foo' => 'bar'];

    $response = LaravelR4nkt::createLeaderboard(
        $customId,
        $name,
        function ($request) use ($description, $customData) {
            $request->description($description)
                ->customData($customData);
        },
    );

    expect($response->status())->toBe(Http::CREATED);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
    expect($response->json('data.description'))->toBe($description);
    expect($response->json('data.custom_data'))->toBe($customData);
});

it('can delete an existing leaderboard', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createLeaderboard(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    expect(
        LaravelR4nkt::deleteLeaderboard($customId)
            ->status()
    )->toBe(Http::NO_CONTENT);

    expect(LaravelR4nkt::listLeaderboards()->collect('data'))->toBeEmpty();
});

it('can get an existing leaderboard', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createLeaderboard(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $response = LaravelR4nkt::getLeaderboard($customId);

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
});

it('can update an existing leaderboard', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createLeaderboard(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $newCustomId = 'new-custom-id';
    $newName = 'new-name';
    $newDescription = 'new-description';
    $newCustomData = ['new' => ['custom' => 'data']];

    $response = LaravelR4nkt::updateLeaderboard(
        $customId,
        function ($request) use ($newCustomId, $newName, $newDescription, $newCustomData) {
            $request->customId($newCustomId)
                ->name($newName)
                ->description($newDescription)
                ->customData($newCustomData);
        },
    );

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.name'))->toBe($newName);
    expect($response->json('data.description'))->toBe($newDescription);
    expect($response->json('data.custom_data'))->toBe($newCustomData);

    expect(LaravelR4nkt::getLeaderboard($customId)->collect('data'))->toBeEmpty();

    $response = LaravelR4nkt::getLeaderboard($newCustomId);
    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.name'))->toBe($newName);
    expect($response->json('data.description'))->toBe($newDescription);
    expect($response->json('data.custom_data'))->toBe($newCustomData);
});

it('can list Leaderboards', function () {
    createBasicLeaderboards($count = 10);

    $response = LaravelR4nkt::listLeaderboards();

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data')->count())->toBe($count);
});

it('can paginate Leaderboards', function () {
    createBasicLeaderboards($count = 10);

    $pageNumber = 2;
    $pageSize = 3;
    $response = LaravelR4nkt::listLeaderboards(function ($request) use ($pageNumber, $pageSize) {
        $request->pageNumber($pageNumber)
            ->pageSize($pageSize);
    });

    expect($response->status())->toBe(Http::OK);
    expect($response->json('meta.current_page'))->toBe($pageNumber);
    expect($response->json('meta.from'))->toBe(4);
    expect($response->json('meta.to'))->toBe(6);
    expect($response->json('meta.last_page'))->toBe(4);
    expect($response->json('meta.per_page'))->toBe($pageSize);
    expect($response->json('meta.total'))->toBe($count);
});

function createBasicLeaderboards(int $count = 1)
{
    debug("Creating {$count} basic leaderboard(s)...");

    for ($x=0; $x < $count; $x++) {
        LaravelR4nkt::createLeaderboard(
            'custom-leaderboard-id-' . $x,
            'leaderboard-name-' . $x,
            function ($request) {
                $request->custom(); // only one standard leaderboard per game allowed...for now...
            },
        );
    }

    return test();
}

function clearLeaderboards()
{
    debug('Clearing all leaderboards...');

    LaravelR4nkt::listLeaderboards()
        ->collect('data')
        ->each(function ($leaderboard) {
            debug(" - Deleting leaderboard: {$leaderboard['custom_id']}");

            expect(
                LaravelR4nkt::deleteLeaderboard($leaderboard['custom_id'])
                    ->status()
            )->toBe(Http::NO_CONTENT);
        });

    return test();
}
