---
layout: page
title: Examples
permalink: /examples/
weight: 3

---

For any models you would like to have their own phone numbers or e-mail addresses, add the appropriate trait:

    use Phonable;  
    use Emailable;
    
...or use the `Contactable` trait to quickly add phones *and* e-mails:
    
    use Contactable;

The above traits simply add the appropriate relationships to your model.  Now, you may query the relationships using
[Eloquent](http://laravel.com/docs/5.1/eloquent-relationships#querying-relations) as you normally would.

**E-mail addresses** are accessed via the "emails()" method (a MorphMany relationship):
{% highlight php %}
<?php

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
{% endhighlight %}


**Phone numbers** are accessed via the "phones()" method (a MorphMany relationship):
{% highlight php %}
<?php

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
{% endhighlight %}
