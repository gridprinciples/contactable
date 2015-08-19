<?php

namespace GridPrinciples\Contactable\Tests;

use GridPrinciples\Contactable\Address;
use GridPrinciples\Contactable\Tests\Cases\UserTestCase;

class AddressAssociation extends UserTestCase
{
    public function test_user_can_associate_a_simple_address()
    {
        $user = $this->createUser();
        $user->addresses()->save(new Address([
            'street' => '123 Fake St.',
        ]));

        $this->assertCount(1, $user->addresses);
        $this->assertContains('123 Fake St.', $user->addresses->lists('street'));
        $this->assertEquals('123 Fake St.', (string) $user->addresses->first()->render());
    }

    public function test_user_can_associate_a_complex_address()
    {
        $user = $this->createUser();
        $user->addresses()->save(new Address([
            'street' => '123 Fake St.',
            'street_extra' => 'Apt 404',
            'city' => 'Springfield',
            'state' => 'ME',
            'zip' => '90210-1337',
        ]));

        $this->assertCount(1, $user->addresses);
        $this->assertContains('123 Fake St.', $user->addresses->lists('street'));
        $this->assertEquals("123 Fake St.\nApt 404\nSpringfield, ME 90210-1337", (string) $user->addresses->first()->render());
    }
}
