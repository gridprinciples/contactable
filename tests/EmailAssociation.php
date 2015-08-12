<?php

namespace GridPrinciples\Party\Tests;

use App\User;
use GridPrinciples\Party\Tests\Cases\DatabaseTestCase;

class EmailAssociation extends DatabaseTestCase
{
    public function test_user_can_associate_one_email_address()
    {
        $this->createUser(['email' => 'me@example.com']);

        $this->seeInDatabase('email_addresses', ['address' => 'me@example.com']);
    }

    public function test_user_can_associate_multiple_email_addresses()
    {
        $this->createUser(['email' => ['multi1@example.com', 'multi2@example.com']]);

        $this->seeInDatabase('email_addresses', ['address' => 'multi1@example.com']);
        $this->seeInDatabase('email_addresses', ['address' => 'multi2@example.com']);
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
    }
}
