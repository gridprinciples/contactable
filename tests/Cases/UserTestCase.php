<?php

namespace GridPrinciples\Contactable\Tests\Cases;

use GridPrinciples\Contactable\Tests\Mocks\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

abstract class UserTestCase extends DatabaseTestCase {

    protected $mockUserClass = User::class;

    protected function createUser($attributes = [])
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
        });

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
