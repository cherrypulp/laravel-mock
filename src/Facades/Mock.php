<?php

namespace Blok\Mock\Facades;

use Illuminate\Support\Facades\Facade;

class Mock extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mock';
    }
}
