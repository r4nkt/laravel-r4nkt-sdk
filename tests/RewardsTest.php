<?php

use JustSteveKing\StatusCode\Http;

uses()->group('reward');

afterEach(function () {
    clearRewards();
});

it('can create a reward', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';
    $description = 'some-description';
    $customData = ['foo' => 'bar'];

    $response = LaravelR4nkt::createReward(
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

it('can delete an existing reward', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createReward(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    expect(
        LaravelR4nkt::deleteReward($customId)
            ->status()
    )->toBe(Http::NO_CONTENT);

    expect(LaravelR4nkt::listRewards()->collect('data'))->toBeEmpty();
});

it('can get an existing reward', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createReward(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $response = LaravelR4nkt::getReward($customId);

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
});

it('can update an existing reward', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createReward(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $newCustomId = 'new-custom-id';
    $newName = 'new-name';
    $newDescription = 'new-description';
    $newCustomData = ['new' => ['custom' => 'data']];

    $response = LaravelR4nkt::updateReward(
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

    expect(LaravelR4nkt::getReward($customId)->collect('data'))->toBeEmpty();

    $response = LaravelR4nkt::getReward($newCustomId);
    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.name'))->toBe($newName);
    expect($response->json('data.description'))->toBe($newDescription);
    expect($response->json('data.custom_data'))->toBe($newCustomData);
});

it('can list rewards', function () {
    createBasicRewards($count = 10);

    $response = LaravelR4nkt::listRewards();

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data')->count())->toBe($count);
});

it('can paginate rewards', function () {
    createBasicRewards($count = 10);

    $pageNumber = 2;
    $pageSize = 3;
    $response = LaravelR4nkt::listRewards(function ($request) use ($pageNumber, $pageSize) {
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

function createBasicRewards(int $count = 1)
{
    debug("Creating {$count} basic reward(s)...");

    for ($x = 0; $x < $count; $x++) {
        LaravelR4nkt::createReward(
            'custom-reward-id-' . $x,
            'reward-name-' . $x,
        );
    }

    return test();
}

function clearRewards()
{
    debug('Clearing all rewards...');

    LaravelR4nkt::listRewards()
        ->collect('data')
        ->each(function ($reward) {
            debug(" - Deleting reward: {$reward['custom_id']}");

            expect(
                LaravelR4nkt::deleteReward($reward['custom_id'])
                    ->status()
            )->toBe(Http::NO_CONTENT);
        });

    return test();
}
