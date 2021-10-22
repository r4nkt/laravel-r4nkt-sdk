<?php

use JustSteveKing\StatusCode\Http;
use R4nkt\LaravelR4nkt\Tests\Scenarios\PrepsGame;

uses(PrepsGame::class)->group('scenario');

beforeEach()->prepGame();

afterEach()->clearAll();

it('correctly awards simple badges', function () {
    /**
     * First, earn a simple badge...
     */
    $simplePlayerId = 'player.earn.simple.badge';

    expect(
        LaravelR4nkt::reportActivity(
            $simplePlayerId,
            'action.slay.a.red.dragon',
        )->status()
    )->toBe(Http::CREATED);

    // sleep(1); /** @todo This may be necessary when hitting a server that processes activities asynchronously. */

    /**
     * Request badges *without* including player/achievement.
     */
    $response = LaravelR4nkt::listPlayerBadges(
        $simplePlayerId,
    );

    expect(collect($response->json('data'))->pluck('custom_achievement_id'))
        ->toHaveCount(1)
        ->toContain(
            'achievement.slay.a.red.dragon',
        );

    expect($response->json('data.0'))
        ->player->toBeNull()
        ->achievement->toBeNull();

    /**
     * Request again, but *include* player/achievement.
     */
    $response = LaravelR4nkt::listPlayerBadges(
        $simplePlayerId,
        function ($request) {
            $request->includePlayer()
                ->includeAchievement();
        }
    );

    expect(collect($response->json('data'))->pluck('custom_achievement_id'))
        ->toHaveCount(1)
        ->toContain(
            'achievement.slay.a.red.dragon',
        );

    expect($response->json('data.0'))
        ->player->not()->toBeNull()
        ->achievement->not()->toBeNull();

    /**
     * Now, earn a complex badge (as well as other badges along the way)...
     */
    $complexPlayerId = 'player.earn.complex.badge';

    // criteria.group.master.player complete when the following criterion
    // is complete:
    //  - criterion.complete.quest
    // along with *both* of the following criteria groups:
    //  - criteria.group.display.of.excellence
    //  - criteria.group.slayer.of.legends
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.complete.quest',
        )->status()
    )->toBe(Http::CREATED);

    // criteria.group.display.of.excellence complete when *any one* of the
    // following criteria groups are complete:
    //  - criteria.group.tomb.raider
    //  - criteria.group.dungeon.destroyer
    //  - criteria.group.thief.extraordinaire
    //  - criteria.group.solver.of.riddles

    // criteria.group.tomb.raider
    //  - criterion.find.50.secret.rooms
    //  - criterion.open.100.chests
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.find.secret.room',
            50,
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.open.chest',
            100,
        )->status()
    )->toBe(Http::CREATED);

    // criteria.group.dungeon.destroyer
    //  - criterion.smash.5.doors
    //  - criterion.break.100.breakables
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.smash.door',
            5,
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.break.breakable',
            100,
        )->status()
    )->toBe(Http::CREATED);

    // criteria.group.thief.extraordinaire
    //  - criterion.detect.5.traps
    //  - criterion.disarm.5.traps
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.detect.trap',
            5,
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.disarm.trap',
            5,
        )->status()
    )->toBe(Http::CREATED);

    // criteria.group.group.solver.of.riddles
    //  - criterion.solve.water.chamber.puzzle
    //  - criterion.solve.lava.field.puzzle
    //  - criterion.solve.clockworks.puzzle
    //  - criterion.solve.five.doors.puzzle
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.solve.water.chamber.puzzle',
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.solve.lava.field.puzzle',
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.solve.clockworks.puzzle',
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.solve.five.doors.puzzle',
        )->status()
    )->toBe(Http::CREATED);

    // criteria.group.slayer.of.legends complete when *all* of the
    // following criteria groups are complete:
    //  - criteria.group.queen.slayer
    //  - criteria.group.monster.slayer
    //  - criteria.group.worm.slayer

    // criteria.group.queen.slayer
    //  - criterion.defeat.ethereal.queen.as.cleric
    //  - criterion.defeat.ethereal.queen.as.rogue
    //  - criterion.defeat.ethereal.queen.as.warrior
    //  - criterion.defeat.ethereal.queen.as.wizard
    expect(
        LaravelR4nkt::reportActivity(
            customPlayerId: $complexPlayerId,
            customActionId: 'action.defeat.ethereal.queen',
            callback: function ($request) {
                $request->customData(['class' => 'cleric']);
            },
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            customPlayerId: $complexPlayerId,
            customActionId: 'action.defeat.ethereal.queen',
            callback: function ($request) {
                $request->customData(['class' => 'rogue']);
            },
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            customPlayerId: $complexPlayerId,
            customActionId: 'action.defeat.ethereal.queen',
            callback: function ($request) {
                $request->customData(['class' => 'warrior']);
            },
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            customPlayerId: $complexPlayerId,
            customActionId: 'action.defeat.ethereal.queen',
            callback: function ($request) {
                $request->customData(['class' => 'wizard']);
            },
        )->status()
    )->toBe(Http::CREATED);

    // criteria.group.monster.slayer
    //  - criterion.slay.100.champions
    //  - criterion.dodge.500.attacks
    //  - criterion.deal.100.critical.strikes
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.slay.champion',
            100,
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.dodge.attack',
            500,
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.deal.critical.strike',
            100,
        )->status()
    )->toBe(Http::CREATED);

    // criteria.group.worm.slayer
    //  - criterion.slay.a.red.dragon
    //  - criterion.slay.hydra
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.slay.a.red.dragon',
        )->status()
    )->toBe(Http::CREATED);
    expect(
        LaravelR4nkt::reportActivity(
            $complexPlayerId,
            'action.slay.hydra',
        )->status()
    )->toBe(Http::CREATED);

    // sleep(3); /** @todo This may be necessary when hitting a server that processes activities asynchronously. */

    $response = LaravelR4nkt::listPlayerBadges($complexPlayerId);

    expect(collect($response->json('data'))->pluck('custom_achievement_id'))
        ->toHaveCount(23)
        ->toContain(
            'achievement.winner',
            'achievement.sherlock',
            'achievement.jack.sparrow',
            'achievement.doorman',
            'achievement.bull.in.china.shop',
            'achievement.caution',
            'achievement.extreme.caution',
            'achievement.sir.traps.a.lot',
            'achievement.smooth.operator',
            'achievement.puzzler',
            'achievement.master.puzzler',
            'achievement.true.cleric',
            'achievement.true.rogue',
            'achievement.classicist',
            'achievement.true.warrior',
            'achievement.conqueror',
            'achievement.champion',
            'achievement.true.wizard',
            'achievement.fred.astair',
            'achievement.bruce.lee',
            'achievement.slay.a.red.dragon',
            'achievement.worm.slayer',
            'achievement.master.player',
        );
});
