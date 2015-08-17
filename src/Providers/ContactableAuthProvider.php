<?php

namespace GridPrinciples\Party\Providers;

use GridPrinciples\Party\EmailAddress;
use GridPrinciples\Party\Tests\Mocks\User;
use GridPrinciples\Party\Party;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;

class ContactableAuthProvider extends EloquentUserProvider implements UserProvider {

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $email = array_get($credentials, 'email');

        $user = User::whereHas('emails', function ($q) use ($email) {
            $q->where('address', '=', $email);
        })->first();

        return $user;
    }

}
