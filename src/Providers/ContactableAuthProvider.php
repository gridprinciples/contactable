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
        $username = array_get($credentials, 'name');

        $email = strtolower($email);
        $username = strtolower($username);

        $query = with(new User)->newQuery();

        if(empty(array_filter(config('contactable.login_methods'))))
        {
            // No login methods active; fail.
            return null;
        }

        if ($email && config('contactable.login_methods.emails')) {
            // login via e-mail
            $query->whereHas('emails', function ($q) use ($email) {
                $q->where('address', '=', $email);
            });
        }

        if ($phone && config('contactable.login_methods.phones')) {
            // login via phone
            $query->whereHas('phones', function ($q) use ($phone) {
                $q->where('raw_number', '=', preg_replace("/[^0-9]/", '', $phone));
            });
        }

        if ($username && config('contactable.login_methods.username')) {
            // login via username
            $query->where('user_name', '=', $username);
        }

        return $query->first();
    }
}
