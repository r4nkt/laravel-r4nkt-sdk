<?php

use JustSteveKing\StatusCode\Http;

uses()->group('player');

afterEach(function () {
    clearPlayers();
});

it('can create an player', function () {
    $customId = 'some-custom-id';
    $timeZone = 'Europe/Copenhagen';
    $customData = ['foo' => 'bar'];

    $response = LaravelR4nkt::createPlayer(
        $customId,
        function ($request) use ($timeZone, $customData) {
            $request->timeZone($timeZone)
                ->customData($customData);
        },
    );

    expect($response->status())->toBe(Http::CREATED);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.time_zone'))->toBe($timeZone);
    expect($response->json('data.custom_data'))->toBe($customData);
});

it('can delete an existing player', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createPlayer(
            $customId,
        )->status()
    )->toBe(Http::CREATED);

    expect(
        LaravelR4nkt::deletePlayer($customId)
            ->status()
    )->toBe(Http::NO_CONTENT);

    expect(LaravelR4nkt::listPlayers()->collect('data'))->toBeEmpty();
});

it('can get an existing player', function () {
    $customId = 'some-custom-id';

    expect(
        LaravelR4nkt::createPlayer(
            $customId,
        )->status()
    )->toBe(Http::CREATED);

    $response = LaravelR4nkt::getPlayer($customId);

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($customId);
});

it('can update an existing player', function () {
    $customId = 'some-custom-id';

    expect(
        LaravelR4nkt::createPlayer(
            $customId,
        )->status()
    )->toBe(Http::CREATED);

    $newCustomId = 'new-custom-id';
    $newTimeZone = 'Australia/Sydney';
    $newCustomData = ['new' => ['custom' => 'data']];

    $response = LaravelR4nkt::updatePlayer(
        $customId,
        function ($request) use ($newCustomId, $newTimeZone, $newCustomData) {
            $request->customId($newCustomId)
                ->timeZone($newTimeZone)
                ->customData($newCustomData);
        },
    );

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.time_zone'))->toBe($newTimeZone);
    expect($response->json('data.custom_data'))->toBe($newCustomData);

    expect(LaravelR4nkt::getPlayer($customId)->collect('data'))->toBeEmpty();

    $response = LaravelR4nkt::getPlayer($newCustomId);
    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.time_zone'))->toBe($newTimeZone);
    expect($response->json('data.custom_data'))->toBe($newCustomData);
});

it('can list players', function () {
    createBasicPlayers($count = 10);

    $response = LaravelR4nkt::listPlayers();

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data')->count())->toBe($count);
});

it('can paginate players', function () {
    createBasicPlayers($count = 10);

    $pageNumber = 2;
    $pageSize = 3;
    $response = LaravelR4nkt::listPlayers(function ($request) use ($pageNumber, $pageSize) {
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

function createBasicPlayers(int $count = 1)
{
    debug("Creating {$count} basic player(s)...");

    for ($x=0; $x < $count; $x++) {
        LaravelR4nkt::createPlayer(
            'custom-player-id-' . $x,
        );
    }

    return test();
}

function clearPlayers()
{
    debug('Clearing all players...');

    LaravelR4nkt::listPlayers()
        ->collect('data')
        ->each(function ($player) {
            debug(" - Deleting player: {$player['custom_id']}");

            expect(
                LaravelR4nkt::deletePlayer($player['custom_id'])
                    ->status()
            )->toBe(Http::NO_CONTENT);
        });

    return test();
}