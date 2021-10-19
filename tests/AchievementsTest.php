<?php

use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\Achievements\GetAchievement;
use R4nkt\LaravelR4nkt\Transporter\Achievements\UpdateAchievement;

uses()->group('achievement');

afterEach(function () {
    clearAchievements();
    clearCriteriaGroups();
});

it('can create an achievement, expecting defaults', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    $response = LaravelR4nkt::createAchievement(
        $customId,
        $name,
    );

    expect($response->status())->toBe(Http::CREATED);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
    expect($response->json('data.description'))->toBeEmpty();
    expect($response->json('data.custom_data'))->toBeNull();
    expect($response->json('data.is_secret'))->toBeFalse();
    expect($response->json('data.points'))->toBe(1);
    expect($response->json('data.custom_criteria_group_id'))->toBeNull();
});

it('can create an achievement, overriding defaults', function () {
    clearAchievements();
    $customId = 'some-custom-id';
    $name = 'some-name';
    $description = 'some-description';
    $isSecret = true;
    $points = 1234;
    $customData = ['foo' => 'bar'];

    $response = LaravelR4nkt::createAchievement(
        $customId,
        $name,
        function ($request) use ($description, $isSecret, $points, $customData) {
            $request->description($description)
                ->isSecret($isSecret)
                ->points($points)
                ->customData($customData);
        },
    );

    expect($response->status())->toBe(Http::CREATED);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
    expect($response->json('data.description'))->toBe($description);
    expect($response->json('data.custom_data'))->toBe($customData);
    expect($response->json('data.is_secret'))->toBe($isSecret);
    expect($response->json('data.points'))->toBe($points);
    // expect($response->json('data.custom_criteria_group_id'))->toBe($customCriteriaGroupId);
});

it('can delete an existing achievement', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createAchievement(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    expect(
        LaravelR4nkt::deleteAchievement($customId)
            ->status()
    )->toBe(Http::NO_CONTENT);

    expect(LaravelR4nkt::listAchievements()->collect('data'))->toBeEmpty();
});

it('can get an existing achievement', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createAchievement(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $response = LaravelR4nkt::getAchievement($customId);

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
});

it('cannot get an achievement without a custom id', function () {
    GetAchievement::build()
        ->send();
})->throws(IncompleteRequest::class);

it('can update an existing achievement', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createAchievement(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $newCustomId = 'new-custom-id';
    $newName = 'new-name';
    $newDescription = 'new-description';
    $newCustomData = ['new' => ['custom' => 'data']];

    $response = LaravelR4nkt::updateAchievement(
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

    expect(LaravelR4nkt::getAchievement($customId)->collect('data'))->toBeEmpty();

    $response = LaravelR4nkt::getAchievement($newCustomId);
    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.name'))->toBe($newName);
    expect($response->json('data.description'))->toBe($newDescription);
    expect($response->json('data.custom_data'))->toBe($newCustomData);
});

it('cannot update an achievement without a custom id', function () {
    UpdateAchievement::build()
        ->send();
})->throws(IncompleteRequest::class);

it('can list achievements', function () {
    createBasicAchievements($count = 10);

    $response = LaravelR4nkt::listAchievements();

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data')->count())->toBe($count);
});

it('can paginate achievements', function () {
    createBasicAchievements($count = 10);

    $pageNumber = 2;
    $pageSize = 3;
    $response = LaravelR4nkt::listAchievements(function ($request) use ($pageNumber, $pageSize) {
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

function createBasicAchievements(int $count = 1)
{
    debug("Creating {$count} basic achievement(s)...");

    for ($x = 0; $x < $count; $x++) {
        LaravelR4nkt::createAchievement(
            'custom-achievement-id-' . $x,
            'achievement-name-' . $x,
        );
    }

    return test();
}

function clearAchievements()
{
    debug('Clearing all achievements...');

    LaravelR4nkt::listAchievements(fn ($request) => $request->pageSize(100)->withSecrets())
        ->collect('data')
        ->each(function ($achievement) {
            debug(" - Deleting achievement: {$achievement['custom_id']}");

            expect(
                LaravelR4nkt::deleteAchievement($achievement['custom_id'])
                    ->status()
            )->toBe(Http::NO_CONTENT);
        });

    return test();
}
