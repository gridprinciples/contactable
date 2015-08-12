<?php

namespace GridPrinciples\Party\Traits;

use GridPrinciples\Party\Party;

trait IsParty
{
    public static function bootIsParty()
    {
        self::saving(function ($model) {
            $model->party->save();
        });
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function emails()
    {
        return $this->party->emails();
    }

    public function setEmailAttribute($value)
    {
        $this->party->email = $value;
    }

    /**
     * Shortcut for setting the name field; sets it on the party.
     * @param $value
     */
    public function setNameAttribute($value)
    {
        if(!$this->party)
        {
            $party = Party::create(['name_short' => $value]);
            $this->party()->associate($party);
        }
        else
        {
            $this->party->name_short = $value;
        }
    }
}
