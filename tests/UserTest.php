<?php

namespace GridPrinciples\Party\Tests;

use GridPrinciples\Party\Tests\Cases\UserTestCase;

class UserTest extends UserTestCase
{
    public function test_creating_a_basic_user_works()
    {
        $this->createUser(['name' => 'Party Guy']);

        $this->seeInDatabase('users', ['short_name' => 'Party Guy']);
    }
}
