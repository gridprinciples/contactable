<?php

namespace GridPrinciples\Party;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailAddress extends Model {

    use SoftDeletes;

    protected $table = 'email_addresses';
    protected $fillable = ['address'];
    protected $visible = ['address'];

    public function emailable()
    {
        return $this->morphTo();
    }

}
