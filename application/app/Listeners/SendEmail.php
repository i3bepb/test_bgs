<?php

namespace App\Listeners;

use App\Events\AfterCreateMember;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendEmail implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  AfterCreateMember  $event
     * @return void
     */
    public function handle(AfterCreateMember $event)
    {
        Log::info('Создан новый участник ' . print_r($event->member->toArray(), true));
    }
}
