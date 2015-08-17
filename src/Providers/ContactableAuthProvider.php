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
        $credentials = array_get($credentials, 'username');
        $credentials = strtolower($credentials); // logins are case-insensitive

        $query = with(new User)->newQuery();

        if (empty(array_filter(config('contactable.login_methods')))) {
            // No login methods active; fail.
            return null;
        }

        if (config('contactable.login_methods.emails')) {
            // login via e-mail
            $query->orWhereHas('emails', function ($q) use ($credentials) {
                $q->where('address', '=', $credentials);
            });
        }

        if (config('contactable.login_methods.phones')) {
            // login via phone
            $query->orWhereHas('phones', function ($q) use ($credentials) {
                $q->where('raw_number', '=', preg_replace("/[^0-9]/", '', $credentials));
            });
        }

        if (config('contactable.login_methods.username')) {
            // login via username
            $query->orWhere('user_name', '=', $credentials);
        }

        return $query->first();
    }
}
