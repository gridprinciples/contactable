<?php

namespace GridPrinciples\Contactable;

use GridPrinciples\Contactable\Traits\IncrementsPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailAddress extends Model {

    use SoftDeletes, IncrementsPosition;

    protected $table = 'email_addresses';
    protected $autoPositionBasedOnFields = ['emailable_id', 'emailable_type'];

    protected $fillable = ['address'];
    protected $visible = ['address'];
    protected $touches = ['emailable'];

    /**
     * Relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function emailable()
    {
        return $this->morphTo();
    }

    /**
     * Morph the `address` field to lowercase.
     *
     * @param $value
     */
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = strtolower($value);
    }

}
