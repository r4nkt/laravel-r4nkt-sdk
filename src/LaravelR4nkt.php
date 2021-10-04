<?php

namespace R4nkt\LaravelR4nkt;

use R4nkt\LaravelR4nkt\Concerns\ManagesActions;
use R4nkt\LaravelR4nkt\Concerns\ManagesLeaderboardRankings;
use R4nkt\LaravelR4nkt\Concerns\ManagesLeaderboards;
use R4nkt\LaravelR4nkt\Concerns\ManagesPlayers;
use R4nkt\LaravelR4nkt\Concerns\ManagesRewards;
use R4nkt\LaravelR4nkt\Concerns\ManagesScores;

class LaravelR4nkt
{
    use ManagesActions;
    use ManagesLeaderboardRankings;
    use ManagesLeaderboards;
    use ManagesPlayers;
    use ManagesRewards;
    use ManagesScores;
}
