<?php

namespace GridPrinciples\Party\Traits;

use GridPrinciples\Party\EmailAddress;
use Illuminate\Support\Collection;

trait Emailable {

    protected $stragglingEmails;

    public static function bootEmailable()
    {
        self::saved(function ($model) {
            $model->saveStragglingEmails();
        });
    }

    public function emails()
    {
        return $this->morphMany(EmailAddress::class, 'emailable');
    }

    public function setEmailAttribute($emails)
    {
        if($emails === FALSE)
        {
            return $this->deleteAssociatedEmails();
        }

        if(is_string($emails))
        {
            // Only one e-mail was passed as a string
            $emails = [$emails];
        }

        if(!is_object($emails) || !class_basename($emails) === 'Collection')
        {
            // Collect the values into a Collection
            $emails = collect((array) $emails);
        }

        return $this->saveEmails($emails);
    }

    protected function saveEmails($emails)
    {
        if($emails === FALSE)
        {
            return $this->emails()->delete();
        }

        foreach($emails as $k => $address)
        {
            if(is_object($address) && get_class($address) === EmailAddress::class)
            {
                // This is already an e-mail address object.
                continue;
            }

            $emails[$k] = new EmailAddress(['address' => $address]);
        }

        if(!$this->exists)
        {
            // Record doesn't exist, so defer until it's saved.
            $this->stragglingEmails = $emails;
            return;
        }

        foreach($emails as $email)
        {
            $email->emailable()->associate($this);
            $email->save();
        }
        return;
    }

    protected function deleteAssociatedEmails()
    {
        $this->stragglingEmails = FALSE;
    }

    public function saveStragglingEmails()
    {
        if($this->stragglingEmails !== NULL)
        {
            return $this->saveEmails($this->stragglingEmails);
        }
    }

}
