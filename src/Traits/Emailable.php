<?php

namespace GridPrinciples\Party\Traits;

use GridPrinciples\Party\EmailAddress;
use Illuminate\Support\Collection;

trait Emailable
{
    /**
     * The relationship to other models.
     *
     * @return mixed
     */
    public function emails()
    {
        return $this->morphMany(EmailAddress::class, 'emailable');
    }
}
