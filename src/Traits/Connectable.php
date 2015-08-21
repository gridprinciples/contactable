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

    function myConnections()
    {
        return $this->belongsToMany(get_called_class(), 'connections', 'party_id', 'other_party_id')
            ->withPivot('name', 'other_name', 'start', 'end');
    }

    function theirConnections()
    {
        return $this->belongsToMany(get_called_class(), 'connections', 'other_party_id', 'party_id')
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
