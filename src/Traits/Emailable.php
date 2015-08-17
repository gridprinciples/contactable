<?php

/**
 * Relates any model with e-mail addresses.
 */

namespace GridPrinciples\Party\Traits;

use GridPrinciples\Party\EmailAddress;

trait Emailable
{
    /**
     * The relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function emails()
    {
        return $this->morphMany(EmailAddress::class, 'emailable');
    }
}
