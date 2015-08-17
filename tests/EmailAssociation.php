<?php

namespace GridPrinciples\Party\Tests;

use GridPrinciples\Party\EmailAddress;
use GridPrinciples\Party\Tests\Cases\UserTestCase;

class EmailAssociation extends UserTestCase
{
    public function test_user_can_associate_one_email_address()
    {
        $user = $this->createUser();
        $user->emails()->save(new EmailAddress(['address' => 'ME@Example.com']));

        $this->assertCount(1, $user->emails);
        $this->assertContains('me@example.com', $user->emails->lists('address'));
    }

    public function test_user_can_associate_multiple_email_addresses()
    {
        $user = $this->createUser();
        $user->emails()->saveMany([
            new EmailAddress(['address' => 'multi1@example.com']),
            new EmailAddress(['address' => 'multi2@example.com']),
        ]);

        $this->assertCount(2, $user->emails);
        $this->assertContains('multi1@example.com', $user->emails->lists('address'));
        $this->assertContains('multi2@example.com', $user->emails->lists('address'));
    }

    public function test_user_can_delete_email_addresses()
    {
        $user = $this->createUser();
        $user->emails()->save(new EmailAddress(['address' => 'delete_immediately@example.com']));
        $user->emails()->delete();

        $this->assertCount(0, $user->emails);
    }
}
