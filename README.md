# Contactable
A [Laravel](http://laravel.com) package designed to enhance Eloquent users (or any other model) with relations to 
multiple e-mail addresses and phone numbers, additionally allowing users to login with any of the above.

## Installation
1. Execute `composer require gridprinciples/contactable` from your project directory.
1. Add the following to the `providers` array in `config/app.php`:

    `GridPrinciples\Contactable\Providers\ContactableServiceProvider::class,`

1. Publish the migrations and config file:

    `php artisan vendor:publish --provider="GridPrinciples\Contactable\Providers\ContactableServiceProvider"`
    
1. Run the migrations: 

    `php artisan migrate`
    
    This will add `email_addresses` and `phone_numbers` tables to your database, as well as make some changes to the `users`
    table.
    
## Usage

In order to use the default login capabilities ("login via e-mail, phone number, or username"):

1. Add the `Contactable` trait to your User model:      
    `use Contactable;`
1. Set the authentication driver by changing `driver` under `config/auth`:  
    `'driver' => 'contactable',`

If you would like additional models to have their own phone numbers or e-mail addresses, add the appropriate
trait to the model:

    use Phonable;  
    use Emailable;
    
...or use the `Contactable` trait to quickly add phones **and** e-mails:
    
    use Contactable;

The above traits simply add the appropriate relationships to your model.

## Examples
