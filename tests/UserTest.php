<?php

namespace GridPrinciples\Contactable\Tests;

use GridPrinciples\Contactable\Tests\Cases\UserTestCase;

class UserTest extends UserTestCase
{
    public function test_creating_a_basic_user_works()
    {
        $this->createUser(['name' => 'Party Guy']);

        $this->seeInDatabase('users', ['name' => 'Party Guy']);
    }
}
