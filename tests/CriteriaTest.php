<?php

use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\Criteria\GetCriterion;
use R4nkt\LaravelR4nkt\Transporter\Criteria\UpdateCriterion;

uses()->group('criterion');

afterEach(function () {
    clearCriteria();
    clearActions();
});

it('can create an criterion', function () {
    $customActionId = 'some-custom-id';
    expect(
        LaravelR4nkt::createAction(
            $customActionId,
            'some-name',
        )->status()
    )->toBe(Http::CREATED);

    $customId = 'some-custom-id';
    $name = 'some-name';
    $description = 'some-description';
    $response = LaravelR4nkt::createCriterion(
        $customId,
        $name,
        $customActionId,
        function ($request) use ($description) {
            $request->description($description);
        },
    );

    expect($response->status())->toBe(Http::CREATED);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
    expect($response->json('data.description'))->toBe($description);
    expect($response->json('data.custom_action_id'))->toBe($customActionId);
});

it('can delete an existing criterion', function () {
    $customActionId = 'some-custom-id';
    expect(
        LaravelR4nkt::createAction(
            $customActionId,
            'some-name',
        )->status()
    )->toBe(Http::CREATED);

    $customId = 'some-custom-id';
    $name = 'some-name';
    expect(
        LaravelR4nkt::createCriterion(
            $customId,
            $name,
            $customActionId,
        )->status()
    )->toBe(Http::CREATED);

    expect(
        LaravelR4nkt::deleteCriterion($customId)
            ->status()
    )->toBe(Http::NO_CONTENT);

    expect(LaravelR4nkt::listCriteria()->collect('data'))->toBeEmpty();
});

it('can get an existing criterion', function () {
    $customActionId = 'some-custom-id';
    expect(
        LaravelR4nkt::createAction(
            $customActionId,
            'some-name',
        )->status()
    )->toBe(Http::CREATED);

    $customId = 'some-custom-id';
    $name = 'some-name';
    expect(
        LaravelR4nkt::createCriterion(
            $customId,
            $name,
            $customActionId,
        )->status()
    )->toBe(Http::CREATED);

    $response = LaravelR4nkt::getCriterion($customId);

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
    expect($response->json('data.custom_action_id'))->toBe($customActionId);
});

it('cannot get an criterion without a custom id', function () {
    GetCriterion::build()
        ->send();
})->throws(IncompleteRequest::class);

it('can update an existing criterion', function () {
    $customActionId = 'some-custom-id';
    expect(
        LaravelR4nkt::createAction(
            $customActionId,
            'some-name',
        )->status()
    )->toBe(Http::CREATED);

    $customId = 'some-custom-id';
    $name = 'some-name';
    expect(
        LaravelR4nkt::createCriterion(
            $customId,
            $name,
            $customActionId,
        )->status()
    )->toBe(Http::CREATED);

    $newCustomActionId = 'another-custom-id';
    expect(
        LaravelR4nkt::createAction(
            $newCustomActionId,
            'another-name',
        )->status()
    )->toBe(Http::CREATED);

    $newCustomId = 'new-custom-id';
    $newName = 'new-name';
    $newDescription = 'new-description';
    $response = LaravelR4nkt::updateCriterion(
        $customId,
        function ($request) use ($newCustomId, $newName, $newDescription, $newCustomActionId) {
            $request->customId($newCustomId)
                ->name($newName)
                ->description($newDescription)
                ->customActionId($newCustomActionId);
        },
    );

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.name'))->toBe($newName);
    expect($response->json('data.description'))->toBe($newDescription);
    expect($response->json('data.custom_action_id'))->toBe($newCustomActionId);

    expect(LaravelR4nkt::getCriterion($customId)->collect('data'))->toBeEmpty();

    $response = LaravelR4nkt::getCriterion($newCustomId);
    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.name'))->toBe($newName);
    expect($response->json('data.description'))->toBe($newDescription);
    expect($response->json('data.custom_action_id'))->toBe($newCustomActionId);
});

it('cannot update an criterion without a custom id', function () {
    UpdateCriterion::build()
        ->send();
})->throws(IncompleteRequest::class);

it('can list criteria', function () {
    createBasicCriteria($count = 10);

    $response = LaravelR4nkt::listCriteria();

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data')->count())->toBe($count);
});

it('can paginate criteria', function () {
    createBasicCriteria($count = 10);

    $pageNumber = 2;
    $pageSize = 3;
    $response = LaravelR4nkt::listCriteria(function ($request) use ($pageNumber, $pageSize) {
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

function createBasicCriteria(int $count = 1)
{
    debug("Creating {$count} basic criterion(s)...");

    $customActionId = 'some-custom-id';
    expect(
        LaravelR4nkt::createAction(
            $customActionId,
            'some-name',
        )->status()
    )->toBe(Http::CREATED);

    for ($x = 0; $x < $count; $x++) {
        LaravelR4nkt::createCriterion(
            'custom-criterion-id-' . $x,
            'criterion-name-' . $x,
            $customActionId,
        );
    }

    return test();
}

function clearCriteria()
{
    debug('Clearing all criteria...');

    LaravelR4nkt::listCriteria()
        ->collect('data')
        ->each(function ($criterion) {
            debug(" - Deleting criterion: {$criterion['custom_id']}");

            expect(
                LaravelR4nkt::deleteCriterion($criterion['custom_id'])
                    ->status()
            )->toBe(Http::NO_CONTENT);
        });

    return test();
}
