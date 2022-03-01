<?php

namespace Modules\Igamification\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Igamification\Events\ActivityWasCompleted;
use Modules\Igamification\Events\ActivityIsIncompleted;

use Modules\Igamification\Events\Handlers\SyncActivityUser;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        
        ActivityWasCompleted::class => [
            SyncActivityUser::class
        ],
        ActivityIsIncompleted::class => [
            SyncActivityUser::class
        ],

    ];
}
