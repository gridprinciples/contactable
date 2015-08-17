<?php

namespace GridPrinciples\Party\Tests\Cases;

use GridPrinciples\Party\Tests\Mocks\User;

abstract class UserTestCase extends DatabaseTestCase {

    protected $mockUserClass = User::class;

    protected function createUser($attributes = [])
    {
        $defaultAttributes = [
            'name' => 'Human Being',
            'password' => bcrypt('password'),
        ];
        $attributes = array_merge($defaultAttributes, $attributes);

        // Mock up the assumed workflow: the app's User model `use`s the Contactable trait.
        $user = $this->getMockForAbstractClass($this->mockUserClass);

        $user->fill($attributes);
        $user->save();

        return $user;
    }
}
