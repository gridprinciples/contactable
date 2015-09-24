<?php

/**
 * Relates any model with e-mail addresses.
 */

namespace GridPrinciples\Contactable\Traits;

use GridPrinciples\Contactable\EmailAddress;

trait Emailable
{
    /**
     * The relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function emails()
    {
        return $this->morphMany(config('contactable.models.email', EmailAddress::class), 'emailable')
            ->orderBy('position', 'asc');
    }

    public function primaryEmail()
    {
        return $this->emails ? $this->emails->first() : null;
    }
}
