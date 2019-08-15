<?php

namespace Blok\Mock;

class Mock
{

    public static function getPath()
    {
        return config("mock.path");
    }

    public static function meetEnvCondition()
    {
        $callable = config("mock.condition");
        return $callable();
    }

}
