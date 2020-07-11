<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(EventSeeder::class);
        // Создаем только мероприятия, а участников оставляем пустым
        // $this->call(MemberSeeder::class);
    }
}
