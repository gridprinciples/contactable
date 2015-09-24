<?php

/**
 * Relates any model with real-world addresses.
 */

namespace GridPrinciples\Contactable\Traits;

use GridPrinciples\Contactable\Address;

trait Addressable
{
    /**
     * The relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(config('contactable.models.address', Address::class), 'addressable');
    }
}
