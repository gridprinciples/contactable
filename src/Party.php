<?php

namespace GridPrinciples\Party;

use GridPrinciples\Party\Traits\Emailable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Party extends Model {

    use SoftDeletes,
        Emailable;

    protected $table = 'parties';
    public $timestamps = false;
    protected $fillable = ['name_legal', 'name_short', 'name'];
    protected $visible = ['name_legal', 'name_short', 'type'];

    public function emails()
    {
        return $this->morphMany(EmailAddress::class, 'emailable');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'party_id');
    }
}
