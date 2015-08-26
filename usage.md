---
layout: page
title: Usage
permalink: /usage/
weight: 2

---

In order to use the default login capabilities ("login via e-mail, phone number, or username"):

1. Add the `Contactable` trait to your User model:

       use Contactable;
       
1. Set the authentication driver by changing `driver` under `config/auth`:
  
       'driver' => 'contactable',

### Using Default Laravel 5.1 Authentication
If you are using Laravel's included authentication (via [the documentation](http://laravel.com/docs/5.1/authentication)),
installing Contactable for logins is a breeze.

1. At to the top of your `AuthController`, add:

       protected $username = 'username';
        
1. Edit your`<input>`'s **name** in `login.blade.php` to **username** instead of **email**.

That's it!  You will need to code your own registration and validation (default implementations are in 
`AuthController`, functions `validator` and `create`).
