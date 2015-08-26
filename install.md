---
layout: page
title: Install
permalink: /install/
weight: 1

---

1. Install via Composer:

       composer require gridprinciples/contactable

1. Add the service provider to the **providers** array in `config/app.php`:

       GridPrinciples\Contactable\Providers\ContactableServiceProvider::class,


1. Publish the migrations and config file:

       php artisan vendor:publish --provider="GridPrinciples\Contactable\Providers\ContactableServiceProvider"

    
1. Run the migrations:

       php artisan migrate
          
    This will add `email_addresses` and `phone_numbers` tables to your database.

1. Remove the `email` column from your `create_users_table` table migration, if applicable.
