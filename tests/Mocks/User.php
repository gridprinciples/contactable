<?php

namespace GridPrinciples\Party\Tests\Mocks;

use App\User as BaseUser;
use GridPrinciples\Party\Traits\Contactable;
use GridPrinciples\Party\Traits\Nameable;

class User extends BaseUser {
    use Contactable;

    protected $morphClass = 'GridPrinciples\Party\Tests\Mocks\User';
}
