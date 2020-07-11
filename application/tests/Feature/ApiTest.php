<?php

namespace Tests\Feature;

use App\Event;
use App\Member;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;

class ApiTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /**
     * Присутствие в ответе заведомо добавленого участника
     * @return void
     * @test
     */
    public function testRequestMembers()
    {
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );
        $eventOne = factory(Event::class)->create();
        $memberOne = factory(Member::class)->create();
        $eventOne->members()->attach($memberOne);
        $json = [
            'eventIds' => [$eventOne->id],
            'page' => 1
        ];
        $this->json('POST', '/api/members', $json)
            ->assertStatus(200)
            ->assertJson(['data' => [$memberOne->toArray()]]);
    }

    /**
     * Добавление участника
     * @return void
     * @test
     */
    public function testCreateMember()
    {
        Queue::fake();
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );
        $eventOne = factory(Event::class)->create();
        $eventTwo = factory(Event::class)->create();
        $json = [
            'name' => 'Иван',
            'surname' => 'Иванов',
            'email' => 'email@ya.ru',
            'eventIds' => [
                $eventOne->id,
                $eventTwo->id,
            ],
        ];
        $this->json('POST', '/api/member', $json)
            ->assertStatus(200)
            ->assertJson(['successfully' => true]);
    }

    /**
     * Обращение без авторизации
     * @return void
     * @test
     */
    public function testUnauthorized()
    {
        $json = [
            'anything' => 'nothing',
        ];
        $this->json('POST', '/api/logout', $json)
            ->assertStatus(401);
    }
}
