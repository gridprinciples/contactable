<?php

namespace GridPrinciples\Party\Tests\Mocks;

use App\User;
use GridPrinciples\Party\Traits\Emailable;

class UserWithEmailableTrait extends User {
    use Emailable;
}
