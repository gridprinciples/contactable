<?php

namespace GridPrinciples\Party\Providers;

use GridPrinciples\Party\EmailAddress;
use GridPrinciples\Party\Tests\Mocks\User;
use GridPrinciples\Party\Party;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;

class ContactableAuthProvider extends EloquentUserProvider implements UserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $email = array_get($credentials, 'email');
        $phone = array_get($credentials, 'phone');

        $query = with(new User)->newQuery();

        $query->orWhereHas('emails', function ($q) use ($email) {
            $q->where('address', '=', $email);
        });

        $query->orWhereHas('phones', function ($q) use ($phone) {
            $q->where('raw_number', '=', preg_replace("/[^0-9]/", '', $phone));
        });

        return $query->first();
    }
}
