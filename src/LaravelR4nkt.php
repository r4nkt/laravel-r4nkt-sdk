<?php

namespace R4nkt\LaravelR4nkt;

use R4nkt\LaravelR4nkt\Concerns\ManagesActions;
use R4nkt\LaravelR4nkt\Concerns\ManagesLeaderboards;
use R4nkt\LaravelR4nkt\Concerns\ManagesPlayers;

class LaravelR4nkt
{
    use ManagesActions;
    use ManagesLeaderboards;
    use ManagesPlayers;
}
