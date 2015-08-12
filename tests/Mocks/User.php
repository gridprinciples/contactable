<?php

namespace GridPrinciples\Party\Tests\Mocks;

use App\User as BaseUser;
use GridPrinciples\Party\Traits\Emailable;
use GridPrinciples\Party\Traits\IsParty;

class User extends BaseUser {
    use IsParty;
}
