<?php

namespace GridPrinciples\Party\Tests\Mocks;

use App\User as BaseUser;
use GridPrinciples\Party\Traits\Emailable;
use GridPrinciples\Party\Traits\IsParty;
use GridPrinciples\Party\Traits\Nameable;

class User extends BaseUser {
    use Emailable,
        Nameable;

    protected $nameField = 'short_name';

    protected $fillable = ['email', 'password', 'name',];
}
