<?php

use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\CriteriaGroups\GetCriteriaGroup;
use R4nkt\LaravelR4nkt\Transporter\CriteriaGroups\UpdateCriteriaGroup;

uses()->group('criteria-group');

afterEach(function () {
    clearCriteriaGroups();
});

it('can create an criteria group', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';
    $description = 'some-description';

    $response = LaravelR4nkt::createCriteriaGroup(
        $customId,
        $name,
        function ($request) use ($description) {
            $request->description($description);
        },
    );

    expect($response->status())->toBe(Http::CREATED);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
    expect($response->json('data.description'))->toBe($description);
});

it('can delete an existing criteria group', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createCriteriaGroup(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    expect(
        LaravelR4nkt::deleteCriteriaGroup($customId)
            ->status()
    )->toBe(Http::NO_CONTENT);

    expect(LaravelR4nkt::listCriteriaGroups()->collect('data'))->toBeEmpty();
});

it('can get an existing criteria group', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createCriteriaGroup(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $response = LaravelR4nkt::getCriteriaGroup($customId);

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
});

it('cannot get an criteria group without a custom id', function () {
    GetCriteriaGroup::build()
        ->send();
})->throws(IncompleteRequest::class);

it('can update an existing criteria group', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createCriteriaGroup(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $newCustomId = 'new-custom-id';
    $newName = 'new-name';
    $newDescription = 'new-description';

    $response = LaravelR4nkt::updateCriteriaGroup(
        $customId,
        function ($request) use ($newCustomId, $newName, $newDescription) {
            $request->customId($newCustomId)
                ->name($newName)
                ->description($newDescription);
        },
    );

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.name'))->toBe($newName);
    expect($response->json('data.description'))->toBe($newDescription);

    expect(LaravelR4nkt::getCriteriaGroup($customId)->collect('data'))->toBeEmpty();

    $response = LaravelR4nkt::getCriteriaGroup($newCustomId);
    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.name'))->toBe($newName);
    expect($response->json('data.description'))->toBe($newDescription);
});

it('cannot update an criteria group without a custom id', function () {
    UpdateCriteriaGroup::build()
        ->send();
})->throws(IncompleteRequest::class);

it('can list criteria groups', function () {
    createBasicCriteriaGroups($count = 10);

    $response = LaravelR4nkt::listCriteriaGroups();

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data')->count())->toBe($count);
});

it('can paginate criteria groups', function () {
    createBasicCriteriaGroups($count = 10);

    $pageNumber = 2;
    $pageSize = 3;
    $response = LaravelR4nkt::listCriteriaGroups(function ($request) use ($pageNumber, $pageSize) {
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

function createBasicCriteriaGroups(int $count = 1)
{
    debug("Creating {$count} basic criteria group(s)...");

    for ($x = 0; $x < $count; $x++) {
        LaravelR4nkt::createCriteriaGroup(
            'custom-criteria-group-id-' . $x,
            'criteria-group-name-' . $x,
        );
    }

    return test();
}

function clearCriteriaGroups()
{
    debug('Clearing all criteria groups...');

    LaravelR4nkt::listCriteriaGroups()
        ->collect('data')
        ->each(function ($criteriaGroup) {
            debug(" - Deleting criteria group: {$criteriaGroup['custom_id']}");

            expect(
                LaravelR4nkt::deleteCriteriaGroup($criteriaGroup['custom_id'])
                    ->status()
            )->toBe(Http::NO_CONTENT);
        });

    return test();
}
