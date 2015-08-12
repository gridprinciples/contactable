<?php

namespace GridPrinciples\Party\Tests;

use App\User;
use GridPrinciples\Party\EmailAddress;
use GridPrinciples\Party\Tests\Cases\DatabaseTestCase;

class EmailAssociation extends DatabaseTestCase
{
    public function test_user_can_associate_one_email_address()
    {
        $user = $this->createUser(['email' => 'me@example.com']);

        $this->assertEquals($user->emails->count(), 1);
    }

    public function test_user_can_associate_multiple_email_addresses()
    {
        $user = $this->createUser(['email' => ['multi1@example.com', 'multi2@example.com']]);

        $this->assertEquals($user->emails->count(), 2);
    }

    public function test_user_can_delete_email_addresses()
    {
        $user = $this->createUser(['email' => 'delete_immediately@example.com']);

        $user->email = false;
        $user->save();

        $this->assertEquals($user->emails->count(), 0);
    }

    private function createUser($attributes = [])
    {
        $defaultAttributes = [
            'name' => 'Human Being',
            'password' => bcrypt('password'),
        ];
        $attributes = array_merge($defaultAttributes, $attributes);

        // Mock up the assumed workflow: the app's User model `use`s the Emailable trait.
        $user = $this->getMockForAbstractClass(Mocks\UserWithEmailableTrait::class);

        $user->fill($attributes);
        $user->save();

        return $user;
    }
}
