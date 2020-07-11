<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Event;
use App\Member;

class TestingDataTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /**
     * Проверяем фабрики
     * @return void
     * @test
     */
    public function testFactory()
    {
        $event = factory(Event::class)->create();
        $this->assertDatabaseHas('event', $event->toArray());
        $member = factory(Member::class)->create();
        $this->assertDatabaseHas('member', $member->toArray());
    }

    /**
     * Проверяем сеялки
     * @return void
     * @test
     */
    public function testEventSeeder()
    {
        $this->seed(\EventSeeder::class);
        $this->assertDatabaseCount('event', 10);
    }

    /**
     * Проверяем сеялки
     * @return void
     * @test
     */
    public function testMemberSeeder()
    {
        $this->seed(\MemberSeeder::class);
        $this->assertDatabaseCount('member', 100);
    }

    /**
     * Проверяем сеялки
     * @return void
     * @test
     */
    public function testSeeders()
    {
        $this->seed();
        $this->assertDatabaseCount('event', 10);
        // $this->assertDatabaseCount('member', 100);
    }

    /**
     * Проверяем выборку из БД
     * @return void
     * @test
     */
    public function testScope()
    {
        // Делаем три мероприятия и привязываем по 10 участников к каждому и проверяем какое кол-во попадает под выборку
        $eventOne = factory(Event::class)->create();
        $eventOne->members()->attach(factory(Member::class, 10)->create());
        $eventTwo = factory(Event::class)->create();
        $eventTwo->members()->attach(factory(Member::class, 10)->create());
        $eventThree = factory(Event::class)->create();
        $eventThree->members()->attach(factory(Member::class, 10)->create());
        $this->assertEquals(10, Member::inEvent([$eventOne->id])->count());
        $this->assertEquals(20, Member::inEvent([$eventOne->id, $eventTwo->id])->count());
        $this->assertEquals(30, Member::inEvent([$eventOne->id, $eventTwo->id, $eventThree->id])->count());
        // Делаем два новых участника и привязываем их к третьему мероприятию, проверяем, что они попадают в выборку по данному мероприятию
        $members = factory(Member::class, 2)->create();
        $eventThree->members()->attach($members);
        /** @var Collection $membersEventThree */
        $membersEventThree = Member::inEvent([$eventThree->id])->get();
        foreach ($members as $member) {
            $this->assertTrue($membersEventThree->contains($member));
        }
        // Добавляем по одному определенному участнику в первое и второе мероприятие и потом проверяем, что они присутствуют в выборке
        $memberOne = factory(Member::class)->create();
        $eventOne->members()->attach($memberOne);
        $memberTwo = factory(Member::class)->create();
        $eventTwo->members()->attach($memberTwo);
        $membersAll = Member::inEvent()->get();
        $this->assertTrue($membersAll->contains($memberOne));
        $this->assertTrue($membersAll->contains($memberTwo));
        // Ну в конце в первом и втором мероприятии по 11 участников, а в третьем мероприятии 12
        $this->assertEquals(11, Member::inEvent([$eventOne->id])->count());
        $this->assertEquals(11, Member::inEvent([$eventTwo->id])->count());
        $this->assertEquals(12, Member::inEvent([$eventThree->id])->count());
    }
}
