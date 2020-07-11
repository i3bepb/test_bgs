<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    protected $table = 'event';
    public $timestamps = false;

    /**
     * Связь мероприятия с участниками
     * @return BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'event_member', 'event_id', 'member_id');
    }
}
