<?php

namespace GridPrinciples\Contactable;

use GridPrinciples\Contactable\Traits\IncrementsPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneNumber extends Model {

    use SoftDeletes, IncrementsPosition;

    protected $table = 'phone_numbers';
    protected $autoPositionBasedOnFields = ['phonable_id', 'phonable_type'];

    protected $fillable = ['number', 'extension', 'type', 'country'];
    protected $visible = ['number', 'extension', 'type', 'country'];
    protected $touches = ['phonable'];

    /**
     * Relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function phonable()
    {
        return $this->morphTo();
    }

    /**
     * Mutator to also set the "raw number" field when setting the phone number field.
     *
     * @param $value
     */
    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = $value;
        $this->raw_number = $value;
    }

    /**
     * Sets the "raw number" field to only contain the entered numbers.
     *
     * @param $value
     */
    public function setRawNumberAttribute($value)
    {
        $this->attributes['raw_number'] = preg_replace("/[^0-9]/", '', $value);
    }

    public function getFullNumberAttribute()
    {
        return $this->getAttribute('number') .
            ($this->getAttribute('extension') ? ' ext. ' . $this->getAttribute('extension') : '');
    }

}
