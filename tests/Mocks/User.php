<?php

namespace GridPrinciples\Contactable\Tests\Mocks;

use App\User as BaseUser;
use GridPrinciples\Contactable\Traits\Contactable;
use GridPrinciples\Contactable\Traits\Nameable;

class User extends BaseUser {
    use Contactable;

    protected $morphClass = 'GridPrinciples\Contactable\Tests\Mocks\User';
}
