<?php

namespace GridPrinciples\Contactable\Traits;

use GridPrinciples\Contactable\ConnectionPivot;

trait Connectable
{
    public function connect($model, $pivot = [])
    {
        return $this->myConnections()->save($model, $pivot);
    }

    public function getConnectionsAttribute()
    {
        if (!array_key_exists('connections', $this->relations)) {
            $this->loadConnections();
        }

        return $this->getRelation('connections');
    }

    public function getActiveConnectionsAttribute()
    {
        return $this->connections->filter(function ($item) {
            $now = new \Carbon\Carbon;

            switch(TRUE)
            {
                // no dates set
                case !$item->pivot->end && !$item->pivot->start:

                // start is set but is in the future
                case !$item->pivot->end && $item->pivot->start && $item->pivot->start < $now:

                // end is set but is in the past
                case !$item->pivot->start && $item->pivot->end && $item->pivot->end > $now:

                // both start and end are set, but we are currently between those dates
                case $item->pivot->start && $item->pivot->start < $now && $item->pivot->end && $item->pivot->end > $now:

                    return true;
                    break;
            }

            // any other scenario fails
            return false;
        });
    }

    public function myConnections()
    {
        return $this->belongsToMany(get_called_class(), 'connections', 'user_id', 'other_user_id')
            ->withPivot('name', 'other_name', 'start', 'end');
    }

    public function theirConnections()
    {
        return $this->belongsToMany(get_called_class(), 'connections', 'other_user_id', 'user_id')
            ->withPivot('name', 'other_name', 'start', 'end');
    }

    protected function loadConnections()
    {
        if (!array_key_exists('connections', $this->relations)) {
            $connections = $this->mergeConnections();

            $this->setRelation('connections', $connections);
        }
    }

    protected function mergeConnections()
    {
        return $this->myConnections->merge($this->theirConnections);
    }

    public function newPivot($parent, array $attributes, $table, $exists)
    {
        return new ConnectionPivot($parent, $attributes, $table, $exists);
    }
}
