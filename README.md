# Contactable [![Build Status](https://travis-ci.org/gridprinciples/Contactable.svg?branch=master)](https://travis-ci.org/gridprinciples/contactable)

A [Laravel 5.1](http://laravel.com/docs/5.1) package designed to enhance Eloquent users (or any other model) with relations to 
multiple e-mail addresses and phone numbers, additionally allowing users to login with any of the above.

## Installation
1. Run `composer require gridprinciples/contactable` from your project directory.
1. Add the following to the `providers` array in `config/app.php`:  
    `GridPrinciples\Contactable\Providers\ContactableServiceProvider::class,`

1. Publish the migrations and config file:  
    `php artisan vendor:publish --provider="GridPrinciples\Contactable\Providers\ContactableServiceProvider"`
    
1. Run the migrations:  
    `php artisan migrate`  
    This will add `email_addresses` and `phone_numbers` tables to your database, as well as make some changes to the
    `users` table.
    
## Usage

In order to use the default login capabilities ("login via e-mail, phone number, or username"):

1. Add the `Contactable` trait to your User model:      
    `use Contactable;`
1. Set the authentication driver by changing `driver` under `config/auth`:  
    `'driver' => 'contactable',`

### Using Default Laravel 5.1 Authentication
If you are using Laravel's included authentication (via [the documentation](http://laravel.com/docs/5.1/authentication)),
installing Contactable for logins is a breeze.

1. Add `protected $username = 'username';` to the top of your `AuthController`.
1. Edit your`<input>`'s **name** in `login.blade.php` **username** instead of **email**.

That's it!  You will need to code your own registration and validation (default implementations are in 
`AuthController`, functions `validator` and `create`).


## Examples
For any models you would like to have their own phone numbers or e-mail addresses, add the appropriate trait:

    use Phonable;  
    use Emailable;
    
...or use the `Contactable` trait to quickly add phones *and* e-mails:
    
    use Contactable;

The above traits simply add the appropriate relationships to your model.  Now, you may query the relationships using
[Eloquent](http://laravel.com/docs/5.1/eloquent-relationships#querying-relations) as you normally would.

**E-mail addresses** are accessed via the "emails()" method (a MorphMany relationship):
```php
// Add an e-mail address to a new model
$model = new Model;
$model->emails()->save(new \GridPrinciples\Contactable\EmailAddress(['address' => 'zero@example.com']));

// Add multiple e-mail addresses to a pre-existing model
$model = Model::find(1);
$model->emails()->saveMany([
    new \GridPrinciples\Contactable\EmailAddress(['address' => 'one@example.com']),
    new \GridPrinciples\Contactable\EmailAddress(['address' => 'two@example.com']),
]);

// Query records which have at least two e-mail addresses
Model::has('emails', '>=', 2)->get();

// Query records which have a specific e-mail address
$address = 'three@example.com';
Model::whereHas('emails', function ($query) use ($address) {
    $query->where('address', '=', $address);
});
```


**Phone numbers** are accessed via the "phones()" method (a MorphMany relationship):
```php
// Add a phone number to a new model
$model = new Model;
$model->phones()->save(new \GridPrinciples\Contactable\PhoneNumber(['number' => '123 4567']));

// Add multiple phone numbers to a pre-existing model
$model = Model::find(1);
$model->phones()->saveMany([
    new \GridPrinciples\Contactable\PhoneNumber(['number' => '(234) 567-8900']),
    new \GridPrinciples\Contactable\PhoneNumber(['number' => '2222222']),
]);

// Query records which have at least two phone numbers
Model::has('phones', '>=', 2)->get();

// Query records which have a specific phone number
$number = '(000) 011-0000';
Model::whereHas('phones', function ($query) use ($number) {
    $query->where('raw_number', '=', preg_replace("/[^0-9]/", '', $number)); // query only the numbers
});
```

