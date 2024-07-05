<?php
// app/Facades/PusherFacade.php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PusherFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pusher';
    }
}
