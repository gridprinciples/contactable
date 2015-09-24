<?php

namespace GridPrinciples\Contactable\Tests;

use GridPrinciples\Contactable\Address;
use GridPrinciples\Contactable\EmailAddress;
use GridPrinciples\Contactable\PhoneNumber;
use GridPrinciples\Contactable\Tests\Cases\UserTestCase;

class Positioning extends UserTestCase {
    public function test_items_are_positioned_on_creation()
    {
        $user = $this->createUser(['name' => 'The Simpsons']);

        $user->emails()->save(new EmailAddress(['address' => 'homer@example.com']));
        $user->emails()->save(new EmailAddress(['address' => 'marge@example.com']));
        $user->emails()->save(new EmailAddress(['address' => 'bart@example.com']));
        $user->emails()->save(new EmailAddress(['address' => 'lisa@example.com']));
        $user->emails()->save(new EmailAddress(['address' => 'maggie@example.com']));

        $user->phones()->save(new PhoneNumber(['number' => '123 456 7890']));
        $user->phones()->save(new PhoneNumber(['number' => '234 567 8901']));
        $user->phones()->save(new PhoneNumber(['number' => '345 678 9012']));

        $user->addresses()->save(new Address(['city' => 'Chattanooga']));
        $user->addresses()->save(new Address(['city' => 'New York']));
        $user->addresses()->save(new Address(['city' => 'Austin']));
        $user->addresses()->save(new Address(['city' => 'San Francisco']));

        $this->assertEquals([0,1,2,3,4], $user->emails()->lists('position')->toArray());
        $this->assertEquals([0,1,2], $user->phones()->lists('position')->toArray());
        $this->assertEquals([0,1,2,3], $user->addresses()->lists('position')->toArray());
    }
}
