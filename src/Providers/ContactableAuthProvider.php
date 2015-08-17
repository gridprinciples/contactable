<?php

namespace GridPrinciples\Contactable\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;

class ContactableAuthProvider extends EloquentUserProvider implements UserProvider
{
    protected $userModel = \App\User::class;

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $username = array_get($credentials, config('contactable.input_key.username'));
        $email = array_get($credentials, config('contactable.input_key.emails'));
        $phone = array_get($credentials, config('contactable.input_key.phones'));

        $query = with(new $this->userModel)->newQuery();

        if (empty(array_filter(config('contactable.login_methods')))) {
            // No login methods active; fail.
            return null;
        }

        if (config('contactable.login_methods.emails')) {
            // login via e-mail
            $query->orWhereHas('emails', function ($q) use ($email) {
                $q->where('address', '=', strtolower($email));
            });
        }

        if (config('contactable.login_methods.phones')) {
            // login via phone
            $query->orWhereHas('phones', function ($q) use ($phone) {
                $q->where('raw_number', '=', preg_replace("/[^0-9]/", '', $phone));
            });
        }

        if (config('contactable.login_methods.username')) {
            // login via username
            $query->orWhere('name', '=', strtolower($username));
        }

        return $query->first();
    }
}
