<?php

return [
    'login_methods' => [
        // Which methods are currently active?
        'username' => true,
        'emails' => true,
        'phones' => true,
    ],
    'input_key' => [
        // Which POST keys to read when logging in.
        //(login_method => input_key)
        'username' => 'username',
        'emails' => 'username',
        'phones' => 'username',
    ],
    'models' => [
        'email' => \GridPrinciples\Contactable\EmailAddress::class,
        'phone' => \GridPrinciples\Contactable\PhoneNumber::class,
        'address' => \GridPrinciples\Contactable\Address::class,
    ]
];
