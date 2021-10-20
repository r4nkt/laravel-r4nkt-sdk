<?php

namespace R4nkt\LaravelR4nkt\Tests\Scenarios;

use Error;
use Exception;
use JustSteveKing\StatusCode\Http;
use LaravelR4nkt;

trait PrepsGame
{
    public function prepGame()
    {
        try {
            $this->buildActions();
            $this->buildCriteria();
            $this->buildCriteriaGroups();
            $this->buildRewards();
            $this->buildAchievements();
            $this->buildLeaderboards();
        } catch (Exception $e) {
            debug("Exception: {$e->getMessage()}");
        } catch (Error $e) {
            debug("Error: {$e->getMessage()}");
        }
    }

    protected function buildActions()
    {
        $actions = [
            [
                'custom_id' => 'action.slay.an.enemy',
                'name' => 'action.slay.an.enemy',
            ],
            [
                'custom_id' => 'action.slay.champion',
                'name' => 'action.slay.champion',
                'custom_reaction_ids' => [
                    'action.slay.an.enemy',
                ],
            ],
            [
                'custom_id' => 'action.slay.a.dragon',
                'name' => 'action.slay.a.dragon',
                'custom_reaction_ids' => [
                    'action.slay.an.enemy',
                ],
            ],
            [
                'custom_id' => 'action.slay.a.red.dragon',
                'name' => 'action.slay.a.red.dragon',
                'custom_reaction_ids' => [
                    'action.slay.a.dragon',
                    'action.slay.champion',
                ],
            ],
            [
                'custom_id' => 'action.slay.hydra',
                'name' => 'action.slay.hydra',
                'custom_reaction_ids' => [
                    'action.slay.an.enemy',
                ],
            ],
            [
                'custom_id' => 'action.heal.self',
                'name' => 'action.heal.self',
            ],
            [
                'custom_id' => 'action.heal.another',
                'name' => 'action.heal.another',
            ],
            [
                'custom_id' => 'action.detect.trap',
                'name' => 'action.detect.trap',
            ],
            [
                'custom_id' => 'action.disarm.trap',
                'name' => 'action.disarm.trap',
            ],
            [
                'custom_id' => 'action.complete.quest',
                'name' => 'action.complete.quest',
            ],
            [
                'custom_id' => 'action.break.breakable',
                'name' => 'action.break.breakable',
            ],
            [
                'custom_id' => 'action.smash.door',
                'name' => 'action.smash.door',
                'custom_reaction_ids' => [
                    'action.break.breakable',
                ],
            ],
            [
                'custom_id' => 'action.solve.puzzle',
                'name' => 'action.solve.puzzle',
            ],
            [
                'custom_id' => 'action.solve.water.chamber.puzzle',
                'name' => 'action.solve.water.chamber.puzzle',
                'custom_reaction_ids' => [
                    'action.solve.puzzle',
                ],
            ],
            [
                'custom_id' => 'action.solve.lava.field.puzzle',
                'name' => 'action.solve.lava.field.puzzle',
                'custom_reaction_ids' => [
                    'action.solve.puzzle',
                ],
            ],
            [
                'custom_id' => 'action.solve.clockworks.puzzle',
                'name' => 'action.solve.clockworks.puzzle',
                'custom_reaction_ids' => [
                    'action.solve.puzzle',
                ],
            ],
            [
                'custom_id' => 'action.solve.five.doors.puzzle',
                'name' => 'action.solve.five.doors.puzzle',
                'custom_reaction_ids' => [
                    'action.solve.puzzle',
                ],
            ],
            [
                'custom_id' => 'action.deal.critical.strike',
                'name' => 'action.deal.critical.strike',
            ],
            [
                'custom_id' => 'action.play.as.wizard',
                'name' => 'action.play.as.wizard',
            ],
            [
                'custom_id' => 'action.play.as.cleric',
                'name' => 'action.play.as.cleric',
            ],
            [
                'custom_id' => 'action.play.as.rogue',
                'name' => 'action.play.as.rogue',
            ],
            [
                'custom_id' => 'action.play.as.warrior',
                'name' => 'action.play.as.warrior',
            ],
            [
                'custom_id' => 'action.play.as.human',
                'name' => 'action.play.as.human',
            ],
            [
                'custom_id' => 'action.play.as.elf',
                'name' => 'action.play.as.elf',
            ],
            [
                'custom_id' => 'action.play.as.dwarf',
                'name' => 'action.play.as.dwarf',
            ],
            [
                'custom_id' => 'action.play.as.halfling',
                'name' => 'action.play.as.halfling',
            ],
            [
                'custom_id' => 'action.die',
                'name' => 'action.die',
            ],
            [
                'custom_id' => 'action.find.secret.room',
                'name' => 'action.find.secret.room',
            ],
            [
                'custom_id' => 'action.open.chest',
                'name' => 'action.open.chest',
            ],
            [
                'custom_id' => 'action.dodge.attack',
                'name' => 'action.dodge.attack',
            ],
            [
                'custom_id' => 'action.dodge.melee.attack',
                'name' => 'action.dodge.melee.attack',
                'custom_reaction_ids' => [
                    'action.dodge.attack',
                ],
            ],
            [
                'custom_id' => 'action.dodge.missile.attack',
                'name' => 'action.dodge.missile.attack',
                'custom_reaction_ids' => [
                    'action.dodge.attack',
                ],
            ],
            [
                'custom_id' => 'action.sell.item',
                'name' => 'action.sell.item',
            ],
            [
                'custom_id' => 'action.use.potion',
                'name' => 'action.use.potion',
            ],
            [
                'custom_id' => 'action.defeat.ethereal.queen',
                'name' => 'action.defeat.ethereal.queen',
                'custom_reaction_ids' => [
                    'action.slay.champion',
                ],
            ],
        ];

        collect($actions)->each(function ($attributes) {
            debug("Creating action: {$attributes['custom_id']}");
            $response = LaravelR4nkt::createAction(
                $attributes['custom_id'],
                $attributes['name'],
                function ($request) use ($attributes) {
                    if (isset($attributes['custom_reaction_ids'])) {
                        $request->customReactionIds($attributes['custom_reaction_ids']);
                    }
                },
            );
            if ($response->status() != Http::CREATED) {
                debug($response->json());
            }
            expect($response->status())->toBe(Http::CREATED);
        });
    }

    protected function buildCriteria()
    {
        $criteria = [
            [
                'custom_id' => 'criterion.slay.a.red.dragon',
                'name' => 'criterion.slay.a.red.dragon',
                'custom_action_id' => 'action.slay.a.red.dragon',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.slay.10.dragons',
                'name' => 'criterion.slay.10.dragons',
                'custom_action_id' => 'action.slay.a.dragon',
                'type' => 'sum',
                'rule' => 'gte:10',
            ],
            [
                'custom_id' => 'criterion.slay.10.enemies',
                'name' => 'criterion.slay.10.enemies',
                'custom_action_id' => 'action.slay.an.enemy',
                'type' => 'sum',
                'rule' => 'gte:10',
            ],
            [
                'custom_id' => 'criterion.smash.5.doors',
                'name' => 'criterion.smash.5.doors',
                'custom_action_id' => 'action.smash.door',
                'type' => 'sum',
                'rule' => 'gte:5',
            ],
            [
                'custom_id' => 'criterion.heal.self.25.times',
                'name' => 'criterion.heal.self.25.times',
                'custom_action_id' => 'action.heal.self',
                'type' => 'sum',
                'rule' => 'gte:25',
            ],
            [
                'custom_id' => 'criterion.slay.hydra',
                'name' => 'criterion.slay.hydra',
                'custom_action_id' => 'action.slay.hydra',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.detect.trap',
                'name' => 'criterion.detect.trap',
                'custom_action_id' => 'action.detect.trap',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.detect.5.traps',
                'name' => 'criterion.detect.5.traps',
                'custom_action_id' => 'action.detect.trap',
                'type' => 'sum',
                'rule' => 'gte:5',
            ],
            [
                'custom_id' => 'criterion.disarm.trap',
                'name' => 'criterion.disarm.trap',
                'custom_action_id' => 'action.disarm.trap',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.disarm.5.traps',
                'name' => 'criterion.disarm.5.traps',
                'custom_action_id' => 'action.disarm.trap',
                'type' => 'sum',
                'rule' => 'gte:5',
            ],
            [
                'custom_id' => 'criterion.complete.quest',
                'name' => 'criterion.complete.quest',
                'custom_action_id' => 'action.complete.quest',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.break.100.breakables',
                'name' => 'criterion.break.100.breakables',
                'custom_action_id' => 'action.break.breakable',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.solve.puzzle',
                'name' => 'criterion.solve.puzzle',
                'custom_action_id' => 'action.solve.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.solve.water.chamber.puzzle',
                'name' => 'criterion.solve.water.chamber.puzzle',
                'custom_action_id' => 'action.solve.water.chamber.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.solve.lava.field.puzzle',
                'name' => 'criterion.solve.lava.field.puzzle',
                'custom_action_id' => 'action.solve.lava.field.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.solve.clockworks.puzzle',
                'name' => 'criterion.solve.clockworks.puzzle',
                'custom_action_id' => 'action.solve.clockworks.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.solve.five.doors.puzzle',
                'name' => 'criterion.solve.five.doors.puzzle',
                'custom_action_id' => 'action.solve.five.doors.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.deal.100.critical.strikes',
                'name' => 'criterion.deal.100.critical.strikes',
                'custom_action_id' => 'action.deal.critical.strike',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.play.as.cleric',
                'name' => 'criterion.play.as.cleric',
                'custom_action_id' => 'action.play.as.cleric',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.rogue',
                'name' => 'criterion.play.as.rogue',
                'custom_action_id' => 'action.play.as.rogue',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.warrior',
                'name' => 'criterion.play.as.warrior',
                'custom_action_id' => 'action.play.as.warrior',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.wizard',
                'name' => 'criterion.play.as.wizard',
                'custom_action_id' => 'action.play.as.wizard',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.dwarf',
                'name' => 'criterion.play.as.dwarf',
                'custom_action_id' => 'action.play.as.dwarf',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.elf',
                'name' => 'criterion.play.as.elf',
                'custom_action_id' => 'action.play.as.elf',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.halfling',
                'name' => 'criterion.play.as.halfling',
                'custom_action_id' => 'action.play.as.halfling',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.human',
                'name' => 'criterion.play.as.human',
                'custom_action_id' => 'action.play.as.human',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.die.once',
                'name' => 'criterion.die.once',
                'custom_action_id' => 'action.die',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.die.10.times',
                'name' => 'criterion.die.10.times',
                'custom_action_id' => 'action.die',
                'type' => 'sum',
                'rule' => 'gte:10',
            ],
            [
                'custom_id' => 'criterion.slay.100.champions',
                'name' => 'criterion.slay.100.champions',
                'custom_action_id' => 'action.slay.champion',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.find.50.secret.rooms',
                'name' => 'criterion.find.50.secret.rooms',
                'custom_action_id' => 'action.find.secret.room',
                'type' => 'sum',
                'rule' => 'gte:50',
            ],
            [
                'custom_id' => 'criterion.open.100.chests',
                'name' => 'criterion.open.100.chests',
                'custom_action_id' => 'action.open.chest',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.dodge.500.attacks',
                'name' => 'criterion.dodge.500.attacks',
                'custom_action_id' => 'action.dodge.attack',
                'type' => 'sum',
                'rule' => 'gte:500',
            ],
            [
                'custom_id' => 'criterion.sell.100.items',
                'name' => 'criterion.sell.100.items',
                'custom_action_id' => 'action.sell.item',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.use.100.potions',
                'name' => 'criterion.use.100.potions',
                'custom_action_id' => 'action.use.potion',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.defeat.ethereal.queen.as.cleric',
                'name' => 'criterion.defeat.ethereal.queen.as.cleric',
                'custom_action_id' => 'action.defeat.ethereal.queen',
                'type' => 'sum',
                'rule' => 'gte:1',
                'conditions' => [
                    'groups' => [
                        [
                            'conditions' => [
                                'activityData:class,eq,cleric',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'custom_id' => 'criterion.defeat.ethereal.queen.as.rogue',
                'name' => 'criterion.defeat.ethereal.queen.as.rogue',
                'custom_action_id' => 'action.defeat.ethereal.queen',
                'type' => 'sum',
                'rule' => 'gte:1',
                'conditions' => [
                    'groups' => [
                        [
                            'conditions' => [
                                'activityData:class,eq,rogue',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'custom_id' => 'criterion.defeat.ethereal.queen.as.warrior',
                'name' => 'criterion.defeat.ethereal.queen.as.warrior',
                'custom_action_id' => 'action.defeat.ethereal.queen',
                'type' => 'sum',
                'rule' => 'gte:1',
                'conditions' => [
                    'groups' => [
                        [
                            'conditions' => [
                                'activityData:class,eq,warrior',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'custom_id' => 'criterion.defeat.ethereal.queen.as.wizard',
                'name' => 'criterion.defeat.ethereal.queen.as.wizard',
                'custom_action_id' => 'action.defeat.ethereal.queen',
                'type' => 'sum',
                'rule' => 'gte:1',
                'conditions' => [
                    'groups' => [
                        [
                            'conditions' => [
                                'activityData:class,eq,wizard',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        collect($criteria)->each(function ($attributes) {
            debug("Creating criterion: {$attributes['custom_id']}");
            $response = LaravelR4nkt::createCriterion(
                $attributes['custom_id'],
                $attributes['name'],
                $attributes['custom_action_id'],
                function ($request) use ($attributes) {
                    $request->type($attributes['type'])
                        ->rule($attributes['rule']);

                    if (isset($attributes['conditions'])) {
                        $request->conditions($attributes['conditions']);
                    }
                },
            );
            if ($response->status() != Http::CREATED) {
                debug($response->json());
            }
            expect($response->status())->toBe(Http::CREATED);
        });
    }

    protected function buildCriteriaGroups()
    {
        $criteriaGroups = [
            [
                'custom_id' => 'criteria.group.queen.slayer',
                'name' => 'criteria.group.queen.slayer',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.defeat.ethereal.queen.as.cleric',
                    'criterion.defeat.ethereal.queen.as.rogue',
                    'criterion.defeat.ethereal.queen.as.warrior',
                    'criterion.defeat.ethereal.queen.as.wizard',
                ],
                'custom_criteria_group_ids' => [],
            ],
            [
                'custom_id' => 'criteria.group.monster.slayer',
                'name' => 'criteria.group.monster.slayer',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.slay.100.champions',
                    'criterion.dodge.500.attacks',
                    'criterion.deal.100.critical.strikes',
                ],
                'custom_criteria_group_ids' => [],
            ],
            [
                'custom_id' => 'criteria.group.worm.slayer',
                'name' => 'criteria.group.worm.slayer',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.slay.a.red.dragon',
                    'criterion.slay.hydra',
                ],
                'custom_criteria_group_ids' => [],
            ],
            [
                'custom_id' => 'criteria.group.slayer.of.legends',
                'name' => 'criteria.group.slayer.of.legends',
                'operator' => 'and',
                'custom_criteria_ids' => [],
                'custom_criteria_group_ids' => [
                    'criteria.group.queen.slayer',
                    'criteria.group.monster.slayer',
                    'criteria.group.worm.slayer',
                ],
            ],
            [
                'custom_id' => 'criteria.group.tomb.raider',
                'name' => 'criteria.group.tomb.raider',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.find.50.secret.rooms',
                    'criterion.open.100.chests',
                ],
                'custom_criteria_group_ids' => [],
            ],
            [
                'custom_id' => 'criteria.group.dungeon.destroyer',
                'name' => 'criteria.group.dungeon.destroyer',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.smash.5.doors',
                    'criterion.break.100.breakables',
                ],
                'custom_criteria_group_ids' => [],
            ],
            [
                'custom_id' => 'criteria.group.thief.extraordinaire',
                'name' => 'criteria.group.thief.extraordinaire',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.detect.5.traps',
                    'criterion.disarm.5.traps',
                ],
                'custom_criteria_group_ids' => [],
            ],
            [
                'custom_id' => 'criteria.group.solver.of.riddles',
                'name' => 'criteria.group.solver.of.riddles',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.solve.water.chamber.puzzle',
                    'criterion.solve.lava.field.puzzle',
                    'criterion.solve.clockworks.puzzle',
                    'criterion.solve.five.doors.puzzle',
                ],
                'custom_criteria_group_ids' => [],
            ],
            [
                'custom_id' => 'criteria.group.display.of.excellence',
                'name' => 'criteria.group.display.of.excellence',
                'operator' => 'or',
                'custom_criteria_ids' => [],
                'custom_criteria_group_ids' => [
                    'criteria.group.tomb.raider',
                    'criteria.group.dungeon.destroyer',
                    'criteria.group.thief.extraordinaire',
                    'criteria.group.solver.of.riddles',
                ],
            ],
            [
                'custom_id' => 'criteria.group.classy',
                'name' => 'criteria.group.classy',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.play.as.cleric',
                    'criterion.play.as.rogue',
                    'criterion.play.as.warrior',
                    'criterion.play.as.wizard',
                ],
                'custom_criteria_group_ids' => [],
            ],
            [
                'custom_id' => 'criteria.group.diversity',
                'name' => 'criteria.group.diversity',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.play.as.dwarf',
                    'criterion.play.as.elf',
                    'criterion.play.as.halfling',
                    'criterion.play.as.human',
                ],
                'custom_criteria_group_ids' => [],
            ],
            [
                'custom_id' => 'criteria.group.master.player',
                'name' => 'criteria.group.master.player',
                'operator' => 'and',
                'custom_criteria_ids' => [
                    'criterion.complete.quest',
                ],
                'custom_criteria_group_ids' => [
                    'criteria.group.display.of.excellence',
                    'criteria.group.slayer.of.legends',
                ],
            ],
        ];

        collect($criteriaGroups)->each(function ($attributes) {
            debug("Creating criteria group: {$attributes['custom_id']}");
            $response = LaravelR4nkt::createCriteriaGroup(
                $attributes['custom_id'],
                $attributes['name'],
                function ($request) use ($attributes) {
                    $request->operator($attributes['operator']);

                    if (isset($attributes['custom_criteria_ids'])) {
                        $request->customCriteriaIds($attributes['custom_criteria_ids']);
                    }

                    if (isset($attributes['custom_criteria_group_ids'])) {
                        $request->customCriteriaGroupIds($attributes['custom_criteria_group_ids']);
                    }
                },
            );
            if ($response->status() != Http::CREATED) {
                debug($response->json());
            }
            expect($response->status())->toBe(Http::CREATED);
        });
    }

    protected function buildRewards()
    {
        $rewards = [
            [
                'custom_id' => 'reward.10.gold.pieces',
                'name' => 'reward.10.gold.pieces',
            ],
            [
                'custom_id' => 'reward.100.gold.pieces',
                'name' => 'reward.100.gold.pieces',
            ],
            [
                'custom_id' => 'reward.1000.gold.pieces',
                'name' => 'reward.1000.gold.pieces',
            ],
            [
                'custom_id' => 'reward.10000.gold.pieces',
                'name' => 'reward.10000.gold.pieces',
            ],
            [
                'custom_id' => 'reward.uncommon.chest',
                'name' => 'reward.uncommon.chest',
            ],
            [
                'custom_id' => 'reward.rare.chest',
                'name' => 'reward.rare.chest',
            ],
            [
                'custom_id' => 'reward.epic.chest',
                'name' => 'reward.epic.chest',
            ],
            [
                'custom_id' => 'reward.legendary.chest',
                'name' => 'reward.legendary.chest',
            ],
            [
                'custom_id' => 'reward.mythic.chest',
                'name' => 'reward.mythic.chest',
            ],
            [
                'custom_id' => 'reward.random.uncommon.weapon',
                'name' => 'reward.random.uncommon.weapon',
            ],
            [
                'custom_id' => 'reward.random.rare.weapon',
                'name' => 'reward.random.rare.weapon',
            ],
            [
                'custom_id' => 'reward.random.epic.weapon',
                'name' => 'reward.random.epic.weapon',
            ],
            [
                'custom_id' => 'reward.random.legendary.weapon',
                'name' => 'reward.random.legendary.weapon',
            ],
            [
                'custom_id' => 'reward.random.mythic.weapon',
                'name' => 'reward.random.mythic.weapon',
            ],
            [
                'custom_id' => 'reward.random.uncommon.armor',
                'name' => 'reward.random.uncommon.armor',
            ],
            [
                'custom_id' => 'reward.random.rare.armor',
                'name' => 'reward.random.rare.armor',
            ],
            [
                'custom_id' => 'reward.random.epic.armor',
                'name' => 'reward.random.epic.armor',
            ],
            [
                'custom_id' => 'reward.random.legendary.armor',
                'name' => 'reward.random.legendary.armor',
            ],
            [
                'custom_id' => 'reward.random.mythic.armor',
                'name' => 'reward.random.mythic.armor',
            ],
            [
                'custom_id' => 'reward.random.uncommon.amulet',
                'name' => 'reward.random.uncommon.amulet',
            ],
            [
                'custom_id' => 'reward.random.rare.amulet',
                'name' => 'reward.random.rare.amulet',
            ],
            [
                'custom_id' => 'reward.random.epic.amulet',
                'name' => 'reward.random.epic.amulet',
            ],
            [
                'custom_id' => 'reward.random.legendary.amulet',
                'name' => 'reward.random.legendary.amulet',
            ],
            [
                'custom_id' => 'reward.random.mythic.amulet',
                'name' => 'reward.random.mythic.amulet',
            ],
        ];

        collect($rewards)->each(function ($attributes) {
            debug("Creating reward: {$attributes['custom_id']}");
            $response = LaravelR4nkt::createReward(
                $attributes['custom_id'],
                $attributes['name'],
            );
            if ($response->status() != Http::CREATED) {
                debug($response->json());
            }
            expect($response->status())->toBe(Http::CREATED);
        });
    }

    protected function buildAchievements()
    {
        $achievements = [
            [
                'custom_id' => 'achievement.slay.a.red.dragon',
                'name' => 'achievement.slay.a.red.dragon',
                'description' => 'achievement.description',
                'is_secret' => false,
                'points' => 100,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.slay.a.red.dragon',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.dragonslayer',
                'name' => 'achievement.dragonslayer',
                'description' => 'slay 10 dragons',
                'is_secret' => false,
                'points' => 100,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.slay.10.dragons',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.champion',
                'name' => 'achievement.champion',
                'description' => 'slay 10 enemies',
                'is_secret' => true,
                'points' => 50,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.slay.10.enemies',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.doorman',
                'name' => 'achievement.doorman',
                'description' => 'smash a door',
                'is_secret' => false,
                'points' => 5,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.smash.5.doors',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.self.helper',
                'name' => 'achievement.self.helper',
                'description' => 'heal self 25 times',
                'is_secret' => false,
                'points' => 25,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.heal.self.25.times',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.worm.slayer',
                'name' => 'achievement.worm.slayer',
                'description' => 'slay a dragon and a hydra',
                'is_secret' => true,
                'points' => 250,
                'custom_criteria_group_id' => 'criteria.group.worm.slayer',
            ],
            [
                'custom_id' => 'achievement.caution',
                'name' => 'achievement.caution',
                'description' => 'detect a trap',
                'is_secret' => false,
                'points' => 10,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.detect.trap',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.extreme.caution',
                'name' => 'achievement.extreme.caution',
                'description' => 'detect 5 traps',
                'is_secret' => false,
                'points' => 50,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.detect.5.traps',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.smooth.operator',
                'name' => 'achievement.smooth.operator',
                'description' => 'disarm trap',
                'is_secret' => false,
                'points' => 10,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.disarm.trap',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.winner',
                'name' => 'achievement.winner',
                'description' => 'complete quest',
                'is_secret' => false,
                'points' => 1000,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.complete.quest',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.bull.in.china.shop',
                'name' => 'achievement.bull.in.china.shop',
                'description' => 'break 100 breakables',
                'is_secret' => false,
                'points' => 50,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.break.100.breakables',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.puzzler',
                'name' => 'achievement.puzzler',
                'description' => 'solve a puzzle',
                'is_secret' => false,
                'points' => 10,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.solve.puzzle',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.master.puzzler',
                'name' => 'achievement.master.puzzler',
                'description' => 'solve water chamber, lava field, clockworks, and five doors puzzles',
                'is_secret' => false,
                'points' => 250,
                'custom_criteria_group_id' => 'criteria.group.solver.of.riddles',
            ],
            [
                'custom_id' => 'achievement.bruce.lee',
                'name' => 'achievement.bruce.lee',
                'description' => 'deliver 100 critical strikes',
                'is_secret' => false,
                'points' => 25,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.deal.100.critical.strikes',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.classy',
                'name' => 'achievement.classy',
                'description' => 'play as each class',
                'is_secret' => false,
                'points' => 50,
                'custom_criteria_group_id' => 'criteria.group.classy',
            ],
            [
                'custom_id' => 'achievement.diversity',
                'name' => 'achievement.diversity',
                'description' => 'play as each race',
                'is_secret' => false,
                'points' => 50,
                'custom_criteria_group_id' => 'criteria.group.diversity',
            ],
            [
                'custom_id' => 'achievement.mortal',
                'name' => 'achievement.mortal',
                'description' => 'die',
                'is_secret' => false,
                'points' => 0,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.die.once',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.suicidal',
                'name' => 'achievement.suicidal',
                'description' => 'die 10 times',
                'is_secret' => false,
                'points' => 0,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.die.10.times',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.conqueror',
                'name' => 'achievement.conqueror',
                'description' => 'slay 100 champions',
                'is_secret' => false,
                'points' => 100,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.slay.100.champions',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.sherlock',
                'name' => 'achievement.sherlock',
                'description' => 'find 50 secret rooms',
                'is_secret' => false,
                'points' => 100,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.find.50.secret.rooms',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.jack.sparrow',
                'name' => 'achievement.jack.sparrow',
                'description' => 'open 100 chests',
                'is_secret' => false,
                'points' => 25,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.open.100.chests',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.fred.astair',
                'name' => 'achievement.fred.astair',
                'description' => 'dodge 500 attacks',
                'is_secret' => false,
                'points' => 150,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.dodge.500.attacks',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.pusher',
                'name' => 'achievement.pusher',
                'description' => 'sell 100 items',
                'is_secret' => false,
                'points' => 10,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.sell.100.items',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.addict',
                'name' => 'achievement.addict',
                'description' => 'consume 100 potions',
                'is_secret' => false,
                'points' => 10,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.use.100.potions',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.true.cleric',
                'name' => 'achievement.true.cleric',
                'description' => 'defeat the ethereal queen as a cleric',
                'is_secret' => false,
                'points' => 50,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.defeat.ethereal.queen.as.cleric',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.true.rogue',
                'name' => 'achievement.true.rogue',
                'description' => 'defeat the ethereal queen as a rogue',
                'is_secret' => false,
                'points' => 50,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.defeat.ethereal.queen.as.rogue',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.true.warrior',
                'name' => 'achievement.true.warrior',
                'description' => 'defeat the ethereal queen as a warrior',
                'is_secret' => false,
                'points' => 50,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.defeat.ethereal.queen.as.warrior',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.true.wizard',
                'name' => 'achievement.true.wizard',
                'description' => 'defeat the ethereal queen as a wizard',
                'is_secret' => false,
                'points' => 50,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.defeat.ethereal.queen.as.wizard',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.classicist',
                'name' => 'achievement.classicist',
                'description' => 'defeat the ethereal queen with each of the four classes',
                'is_secret' => false,
                'points' => 500,
                'custom_criteria_group_id' => 'criteria.group.queen.slayer',
            ],
            [
                'custom_id' => 'achievement.sir.traps.a.lot',
                'name' => 'achievement.sir.traps.a.lot',
                'description' => 'disarm five traps',
                'is_secret' => false,
                'points' => 15,
                'criteria_group_definition' => [
                    'criteria' => [
                        'criterion.disarm.5.traps',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.master.player',
                'name' => 'achievement.master.player',
                'description' => 'has shown a display of excellence and is known as a slayer of legends',
                'is_secret' => false,
                'points' => 2500,
                'custom_criteria_group_id' => 'criteria.group.master.player',
            ],
        ];

        collect($achievements)->each(function ($attributes) {
            debug("Creating achievement: {$attributes['custom_id']}");
            $response = LaravelR4nkt::createAchievement(
                $attributes['custom_id'],
                $attributes['name'],
                function ($request) use ($attributes) {
                    $request->description($attributes['description'])
                        // ->type($attributes['type'])
                        ->isSecret($attributes['is_secret'])
                        ->points($attributes['points']);

                    if (isset($attributes['custom_criteria_group_id'])) {
                        $request->customCriteriaGroupId($attributes['custom_criteria_group_id']);
                    }

                    if (isset($attributes['criteria_group_definition'])) {
                        $request->criteriaGroupDefinition($attributes['criteria_group_definition']);
                    }
                },
            );
            if ($response->status() != Http::CREATED) {
                debug($response->json());
            }
            expect($response->status())->toBe(Http::CREATED);
        });
    }

    protected function buildLeaderboards()
    {
        // No need to create a default leaderboard...right?
        // $leaderboards = [
        //     [
        //         'custom_id' => 'leaderboard.default',
        //         'name' => 'leaderboard.default',
        //         'description' => 'leaderboard.description',
        //         'type' => 'standard',
        //     ],
        // ];

        // collect($leaderboards)->each(function ($attributes) {
        //     debug("Creating leaderboard: {$attributes['custom_id']}");
        //     expect(
        //         LaravelR4nkt::createLeaderboard(
        //             $attributes['custom_id'],
        //             $attributes['name'],
        //             function ($request) use ($attributes) {
        //                 $request->description($attributes['description']);
        //             },
        //         )->status()
        //     )->toBe(Http::CREATED);
        // });
    }
}
