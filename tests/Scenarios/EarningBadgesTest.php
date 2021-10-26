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

    LaravelR4nkt::queueActivityReport(
        customPlayerId: $simplePlayerId,
        customActionId: 'action.slay.a.red.dragon',
    );

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
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.complete.quest',
    );

    // criteria.group.display.of.excellence complete when *any one* of the
    // following criteria groups are complete:
    //  - criteria.group.tomb.raider
    //  - criteria.group.dungeon.destroyer
    //  - criteria.group.thief.extraordinaire
    //  - criteria.group.solver.of.riddles

    // criteria.group.tomb.raider
    //  - criterion.find.50.secret.rooms
    //  - criterion.open.100.chests
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.find.secret.room',
        amount: 50,
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.open.chest',
        amount: 100,
    );

    // criteria.group.dungeon.destroyer
    //  - criterion.smash.5.doors
    //  - criterion.break.100.breakables
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.smash.door',
        amount: 5,
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.break.breakable',
        amount: 100,
    );

    // criteria.group.thief.extraordinaire
    //  - criterion.detect.5.traps
    //  - criterion.disarm.5.traps
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.detect.trap',
        amount: 5,
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.disarm.trap',
        amount: 5,
    );

    // criteria.group.group.solver.of.riddles
    //  - criterion.solve.water.chamber.puzzle
    //  - criterion.solve.lava.field.puzzle
    //  - criterion.solve.clockworks.puzzle
    //  - criterion.solve.five.doors.puzzle
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.solve.water.chamber.puzzle',
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.solve.lava.field.puzzle',
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.solve.clockworks.puzzle',
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.solve.five.doors.puzzle',
    );

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
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.defeat.ethereal.queen',
        customData: ['class' => 'cleric'],
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.defeat.ethereal.queen',
        customData: ['class' => 'rogue'],
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.defeat.ethereal.queen',
        customData: ['class' => 'warrior'],
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.defeat.ethereal.queen',
        customData: ['class' => 'wizard'],
    );

    // criteria.group.monster.slayer
    //  - criterion.slay.100.champions
    //  - criterion.dodge.500.attacks
    //  - criterion.deal.100.critical.strikes
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.slay.champion',
        amount: 100,
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.dodge.attack',
        amount: 500,
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.deal.critical.strike',
        amount: 100,
    );

    // criteria.group.worm.slayer
    //  - criterion.slay.a.red.dragon
    //  - criterion.slay.hydra
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.slay.a.red.dragon',
    );
    LaravelR4nkt::queueActivityReport(
        customPlayerId: $complexPlayerId,
        customActionId: 'action.slay.hydra',
    );

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
