<?php

namespace GridPrinciples\Contactable\Tests\Mocks;

use GridPrinciples\Contactable\Providers\ContactableAuthProvider as BaseContactableAuthProvider;

class ContactableAuthProvider extends BaseContactableAuthProvider {

    protected $userModel = \GridPrinciples\Contactable\Tests\Mocks\User::class;

}
