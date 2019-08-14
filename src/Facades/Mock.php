<?php

namespace blok\mock\Facades;

use Illuminate\Support\Facades\Facade;

class mock extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mock';
    }
}
