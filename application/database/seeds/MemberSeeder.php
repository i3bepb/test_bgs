<?php

use Illuminate\Database\Seeder;
use App\Member;
use App\Event;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = Event::all();
        $countEventExist = $events->count();
        if ($countEventExist < 3) {
            $events = factory(Event::class, 10)->create();
            $countEventExist = $events->count();
        }
        factory(Member::class, 100)->create()->each(function ($member) use ($events, $countEventExist) {
            /** @var Member $member */
            $randomIndex = rand(1, $countEventExist -2);
            $shuffleEvents = $events->shuffle();
            $member->events()->saveMany($shuffleEvents->slice($randomIndex, 2));
        });
    }
}
