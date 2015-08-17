<?php

namespace GridPrinciples\Party\Tests\Mocks;

use GridPrinciples\Party\Traits\Nameable;
use Illuminate\Database\Eloquent\Model;

class Album extends Model {
    use Nameable;

    protected $nameField = 'title';

    protected $fillable = ['name', 'title'];
}
