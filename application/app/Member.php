<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Member
 * @package App
 * @method static Builder inEvent(array $eventIds = [])
 * @method static Member findOrFail(int $id)
 * @method static Member|null find(int $id)
 */
class Member extends Model
{
    protected $table = 'member';


    /**
     * Связь участника с мероприятиями
     * @return BelongsToMany
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_member', 'member_id', 'event_id');
    }

    /**
     * @param Builder $query
     * @param array $eventIds
     * @return mixed
     */
    public function scopeInEvent($query, $eventIds = [])
    {
        if (empty($eventIds)) {
            return $query;
        }
        return $query->whereHas('events', function($q) use ($eventIds) {
            $q->whereIn('event_id', $eventIds);
        });
    }
}
