<?php

use R4nkt\LaravelR4nkt\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function debug($dump)
{
    // dump($dump);
}

function clearAll()
{
    clearPlayers();
    clearLeaderboards();
    clearAchievements();
    clearRewards();
    clearCriteriaGroups();
    clearCriteria();
    clearActions();
}
