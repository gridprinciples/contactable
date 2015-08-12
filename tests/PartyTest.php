<?php

namespace GridPrinciples\Party\Tests;

use GridPrinciples\Party\Tests\Cases\UserTestCase;

class PartyTest extends UserTestCase
{
    public function test_creating_a_user_creates_a_party()
    {
        $user = $this->createUser(['name' => 'Party Guy']);

        $this->seeInDatabase('parties', ['name_short' => 'Party Guy']);
    }
}
