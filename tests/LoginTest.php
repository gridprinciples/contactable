<?php

namespace GridPrinciples\Party\Tests;

use GridPrinciples\Party\EmailAddress;
use GridPrinciples\Party\PhoneNumber;
use GridPrinciples\Party\Tests\Cases\UserTestCase;
use Illuminate\Support\Facades\Auth;

class LoginTest extends UserTestCase
{
    public function test_user_cannot_log_in_with_bad_credentials()
    {
        $user = $this->createUser(['password' => bcrypt('password')]);

        $this->assertFalse(Auth::attempt(['username' => 'whatever', 'password' => 'badpassword']));
    }

    public function test_user_can_log_in_with_single_email()
    {
        $user = $this->createUser(['password' => bcrypt('password')]);
        $user->emails()->save(new EmailAddress(['address' => 'loggerinner@example.com']));

        $this->assertTrue(Auth::attempt(['username' => 'loggerinner@example.com', 'password' => 'password']));
    }

    public function test_user_can_log_in_with_any_email()
    {
        $user = $this->createUser(['password' => bcrypt('otherpassword')]);
        $user->emails()->saveMany([
            new EmailAddress(['address' => 'newguy1@example.com']),
            new EmailAddress(['address' => 'newguy2@example.com']),
        ]);

        $this->assertTrue(Auth::attempt(['username' => 'newguy1@example.com', 'password' => 'otherpassword']));
        $this->assertTrue(Auth::attempt(['username' => 'newguy2@example.com', 'password' => 'otherpassword']));
    }

    public function test_user_can_log_in_with_single_phone()
    {
        $user = $this->createUser(['password' => bcrypt('othernewpassword')]);
        $user->phones()->save(new PhoneNumber(['number' => '123 456 7890']));

        $this->assertTrue(Auth::attempt(['username' => '123 4567890', 'password' => 'othernewpassword']));
    }

    public function test_user_can_log_in_with_any_phone()
    {
        $user = $this->createUser(['password' => bcrypt('othernewishpassword')]);
        $user->phones()->saveMany([
            new PhoneNumber(['number' => '(444) 444-4444']),
            new PhoneNumber(['number' => '423 123 9876']),
        ]);

        $this->assertTrue(Auth::attempt(['username' => '444 4444444', 'password' => 'othernewishpassword']));
        $this->assertTrue(Auth::attempt(['username' => '4231239876', 'password' => 'othernewishpassword']));
    }

    public function test_user_can_log_in_with_username()
    {
        $user = $this->createUser(['user_name' => 'megaguy', 'password' => bcrypt('usernamepassword')]);

        $this->assertTrue(Auth::attempt(['username' => 'Megaguy', 'password' => 'usernamepassword']));
    }

    public function test_user_cannot_login_with_disabled_method()
    {
        $user = $this->createUser(['password' => bcrypt('jeffjefftyjeff')]);

        $user->emails()->saveMany([
            new EmailAddress(['address' => 'notforlogin@example.com']),
        ]);

        $user->phones()->saveMany([
            new PhoneNumber(['number' => '0118 999 881 999 119 725 3']),
        ]);

        // We should be able to login with these credentials, for now.
        $this->assertTrue(Auth::attempt(['username' => '01189998819991197253', 'password' => 'jeffjefftyjeff']));
        $this->assertTrue(Auth::attempt(['username' => 'notforlogin@example.com', 'password' => 'jeffjefftyjeff']));

        config(['contactable.login_methods' => [
            'phones' => false,
            'emails' => false,
        ]]);

        // Now we've turned them off, so no logging in.
        $this->assertFalse(Auth::attempt(['username' => '01189998819991197253', 'password' => 'jeffjefftyjeff']));
        $this->assertFalse(Auth::attempt(['username' => 'notforlogin@example.com', 'password' => 'jeffjefftyjeff']));
    }
}
