<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable(false)->default('')->comment('Название мероприятия');
            $table->date('date_of')->nullable(false)->comment('Дата проведения мероприятия');
            $table->string('city')->nullable(false)->default('Екатеринбург')->comment('Город проведения мероприятия');
        });
        Schema::create('member', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable(false)->default('')->comment('Имя участника');
            $table->string('surname', 100)->nullable(false)->default('')->comment('Фамилия участника');
            $table->string('email', 100)->nullable(false)->comment('Email участника');
            $table->unique('email');
            $table->timestamps();
        });
        Schema::create('event_member', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id', false)->nullable(false);
            $table->unsignedBigInteger('member_id', false)->nullable(false);
            $table->primary(['event_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_member');
        Schema::dropIfExists('event');
        Schema::dropIfExists('member');
    }
}
