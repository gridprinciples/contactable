<?php

namespace GridPrinciples\Party\Tests;

use GridPrinciples\Party\Tests\Cases\UserTestCase;
use GridPrinciples\Party\Tests\Mocks\User;

class EmailAssociation extends UserTestCase
{
    protected $mockUserClass = User::class;

    public function test_user_can_associate_one_email_address()
    {
        $user = $this->createUser(['email' => 'me@example.com']);

        $this->assertCount(1, $user->emails);
        $this->assertContains('me@example.com', $user->emails->lists('address'));
    }

    public function test_user_can_associate_multiple_email_addresses()
    {
        $user = $this->createUser(['email' => ['multi1@example.com', 'multi2@example.com']]);

        $this->assertCount(2, $user->emails);
        $this->assertContains('multi1@example.com', $user->emails->lists('address'));
        $this->assertContains('multi2@example.com', $user->emails->lists('address'));
    }

    public function test_user_can_delete_email_addresses()
    {
        $user = $this->createUser(['email' => 'delete_immediately@example.com']);

        $user->email = false;
        $user->save();

        $this->assertCount(0, $user->emails);
    }
}
