<?php

namespace GridPrinciples\Party;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneNumber extends Model {

    use SoftDeletes;

    protected $table = 'phone_number';
    protected $fillable = ['number', 'type', 'country'];
    protected $visible = ['number', 'type', 'country'];

    /**
     * Relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function phonable()
    {
        return $this->morphTo();
    }

}
