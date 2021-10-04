<?php

use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Exceptions\IncompleteRequest;
use R4nkt\LaravelR4nkt\Transporter\Actions\GetAction;
use R4nkt\LaravelR4nkt\Transporter\Actions\UpdateAction;

uses()->group('action');

afterEach(function () {
    clearActions();
});

it('can create an action', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';
    $description = 'some-description';
    $customData = ['foo' => 'bar'];

    $response = LaravelR4nkt::createAction(
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

it('can delete an existing action', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createAction(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    expect(
        LaravelR4nkt::deleteAction($customId)
            ->status()
    )->toBe(Http::NO_CONTENT);

    expect(LaravelR4nkt::listActions()->collect('data'))->toBeEmpty();
});

it('can get an existing action', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createAction(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $response = LaravelR4nkt::getAction($customId);

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
});

it('cannot get an action without a custom id', function () {
    GetAction::build()
        ->send();
})->throws(IncompleteRequest::class);

it('can update an existing action', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(
        LaravelR4nkt::createAction(
            $customId,
            $name,
        )->status()
    )->toBe(Http::CREATED);

    $newCustomId = 'new-custom-id';
    $newName = 'new-name';
    $newDescription = 'new-description';
    $newCustomData = ['new' => ['custom' => 'data']];

    $response = LaravelR4nkt::updateAction(
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

    expect(LaravelR4nkt::getAction($customId)->collect('data'))->toBeEmpty();

    $response = LaravelR4nkt::getAction($newCustomId);
    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($newCustomId);
    expect($response->json('data.name'))->toBe($newName);
    expect($response->json('data.description'))->toBe($newDescription);
    expect($response->json('data.custom_data'))->toBe($newCustomData);
});

it('cannot update an action without a custom id', function () {
    UpdateAction::build()
        ->send();
})->throws(IncompleteRequest::class);

it('can list actions', function () {
    createBasicActions($count = 10);

    $response = LaravelR4nkt::listActions();

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data')->count())->toBe($count);
});

it('can paginate actions', function () {
    createBasicActions($count = 10);

    $pageNumber = 2;
    $pageSize = 3;
    $response = LaravelR4nkt::listActions(function ($request) use ($pageNumber, $pageSize) {
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

function createBasicActions(int $count = 1)
{
    debug("Creating {$count} basic action(s)...");

    for ($x = 0; $x < $count; $x++) {
        LaravelR4nkt::createAction(
            'custom-action-id-' . $x,
            'action-name-' . $x,
        );
    }

    return test();
}

function clearActions()
{
    debug('Clearing all actions...');

    LaravelR4nkt::listActions()
        ->collect('data')
        ->each(function ($action) {
            debug(" - Deleting action: {$action['custom_id']}");

            expect(
                LaravelR4nkt::deleteAction($action['custom_id'])
                    ->status()
            )->toBe(Http::NO_CONTENT);
        });

    return test();
}
