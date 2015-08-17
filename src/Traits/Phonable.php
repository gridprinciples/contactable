<?php

/**
 * Relates any model with phone numbers.
 */

namespace GridPrinciples\Party\Traits;

use GridPrinciples\Party\PhoneNumber;

trait Phonable
{
    /**
     * The relationship to other models.
     *
     * @return mixed
     */
    public function phones()
    {
        return $this->morphMany(PhoneNumber::class, 'phonable');
    }
}
