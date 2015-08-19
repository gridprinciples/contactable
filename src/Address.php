<?php

namespace GridPrinciples\Contactable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {

    use SoftDeletes;

    protected $table = 'addresses';
    protected $fillable = ['street', 'street_extra', 'city', 'subdivision', 'state', 'province', 'postal_code', 'zip', 'zip_code', 'country'];
    protected $visible = ['street', 'street_extra', 'city', 'subdivision', 'postal_code', 'country'];

    /**
     * Relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    public function setStateAttribute($value)
    {
        $this->setAttribute('subdivision', $value);
    }

    public function setProvinceAttribute($value)
    {
        $this->setAttribute('subdivision', $value);
    }

    public function setZipAttribute($value)
    {
        $this->setAttribute('postal_code', $value);
    }

    public function setZipCodeAttribute($value)
    {
        $this->setAttribute('postal_code', $value);
    }

    public function render()
    {
//        return trans('contactable::address', $this->toArray());
        return view('contactable::address.' . $this->country, $this->toArray());
    }

    public function __toString()
    {
        return $this->render();
    }
}
