<?php

namespace GridPrinciples\Party\Tests;

use GridPrinciples\Party\EmailAddress;
use GridPrinciples\Party\Tests\Cases\UserTestCase;
use Illuminate\Support\Facades\Auth;

class LoginTest extends UserTestCase
{
    public function test_user_can_log_in()
    {
        $user = $this->createUser(['name' => 'Logger Inner', 'password' => bcrypt('password')]);
        $user->emails()->save(new EmailAddress(['address' => 'loggerinner@example.com']));

        $this->assertTrue(Auth::attempt(['email' => 'loggerinner@example.com', 'password' => 'password']));
    }
}
