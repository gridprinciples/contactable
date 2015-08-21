<?php

namespace GridPrinciples\Contactable\Tests\Mocks;

use App\User as BaseUser;
use GridPrinciples\Contactable\Traits\Connectable;
use GridPrinciples\Contactable\Traits\Contactable;
use GridPrinciples\Contactable\Traits\Nameable;

class User extends BaseUser {
    use Contactable,
        Connectable;

    protected $morphClass = 'GridPrinciples\Contactable\Tests\Mocks\User';
}
