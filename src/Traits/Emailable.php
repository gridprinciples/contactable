<?php

namespace GridPrinciples\Party\Traits;

use GridPrinciples\Party\EmailAddress;
use Illuminate\Support\Collection;

trait Emailable {

    protected $stragglingEmails;

    /**
     * Load this trait.
     */
    public static function bootEmailable()
    {
        self::saved(function ($model) {
            $model->saveStragglingEmails();
        });
    }

    /**
     * The relationship to other models.
     *
     * @return mixed
     */
    public function emails()
    {
        return $this->morphMany(EmailAddress::class, 'emailable');
    }

    /**
     * Mutator for the e-mail address "field", really a relationship.
     *
     * @param $emails
     */
    public function setEmailAttribute($emails)
    {
        if($emails === FALSE)
        {
            $this->deleteAssociatedEmails();
            return;
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

        $this->saveEmails($emails);
    }

    /**
     * Given a Collection (or false), save as the current e-mails.
     *
     * @param $emails Collection|boolean
     * @return $this
     */
    protected function saveEmails($emails)
    {
        if($emails === FALSE)
        {
            $this->emails()->delete();
            return;
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
        }
        else
        {
            foreach($emails as $email)
            {
                $email->emailable()->associate($this);
                $email->save();
            }
        }


        return;
    }

    /**
     * Delete all associated e-mails, on save.
     */
    protected function deleteAssociatedEmails()
    {
        $this->stragglingEmails = FALSE;
    }

    /**
     * Save any cached "stragglers".
     */
    protected function saveStragglingEmails()
    {
        if($this->stragglingEmails !== NULL)
        {
            $this->saveEmails($this->stragglingEmails);
        }
    }

}