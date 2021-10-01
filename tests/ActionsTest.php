<?php

use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Transporter\Actions\CreateAction;
use R4nkt\LaravelR4nkt\Transporter\Actions\DeleteAction;
use R4nkt\LaravelR4nkt\Transporter\Actions\GetAction;
use R4nkt\LaravelR4nkt\Transporter\Actions\ListActions;

afterEach(function () {
    clearActions();
});

it('can create an action', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    $response = CreateAction::build()
        ->customId($customId)
        ->name($name)
        ->send();

    expect($response->status())->toBe(Http::CREATED);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
});

it('can delete an existing action', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(CreateAction::build()
        ->customId($customId)
        ->name($name)
        ->send()
        ->status()
    )
    ->toBe(Http::CREATED);

    expect(DeleteAction::build()
        ->customId($customId)
        ->send()
        ->status())
    ->toBe(Http::NO_CONTENT);

    expect(ListActions::build()
        ->send()
        ->collect('data'))
    ->toBeEmpty();
});

it('can get an existing action', function () {
    $customId = 'some-custom-id';
    $name = 'some-name';

    expect(CreateAction::build()
        ->customId($customId)
        ->name($name)
        ->send()
        ->status()
    )
    ->toBe(Http::CREATED);

    $response = GetAction::build()
        ->customId($customId)
        ->send();

    expect($response->status())->toBe(Http::OK);
    expect($response->json('data.custom_id'))->toBe($customId);
    expect($response->json('data.name'))->toBe($name);
});

it('can list actions', function () {
    createBasicActions($count = 10);

    $response = ListActions::build()
        ->send();

    expect($response->status())->toBe(Http::OK);
    expect($response->collect('data')->count())->toBe($count);
});

it('can paginate actions', function () {
    createBasicActions($count = 10);

    $pageNumber = 2;
    $pageSize = 3;
    $response = ListActions::build()
        ->pageNumber($pageNumber)
        ->pageSize($pageSize)
        ->send();

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
    dump("Creating {$count} basic action(s)...");

    for ($x=0; $x < $count; $x++) {
        CreateAction::build()
            ->customId('custom-action-id-' . $x)
            ->name('action-name-' . $x)
            ->send();
    }

    return test();
}

function clearActions()
{
    dump('Clearing all actions...');

    ListActions::build()
        ->send()
        ->collect('data')
        ->each(function ($action) {
            dump(" - Deleting action: {$action['custom_id']}");
            expect(DeleteAction::build()
                ->customId($action['custom_id'])
                ->send()
                ->status()
            )
                ->toBe(Http::NO_CONTENT);
        });

    return test();
}
