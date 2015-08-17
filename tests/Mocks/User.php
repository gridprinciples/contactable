<?php

namespace GridPrinciples\Party\Tests\Mocks;

use App\User as BaseUser;
use GridPrinciples\Party\Traits\Contactable;
use GridPrinciples\Party\Traits\IsParty;
use GridPrinciples\Party\Traits\Nameable;

class User extends BaseUser {
    use Contactable,
        Nameable;

    protected $nameField = 'short_name';

    protected $fillable = ['email', 'password', 'name'];

    protected $morphClass = 'GridPrinciples\Party\Tests\Mocks\User';
}
