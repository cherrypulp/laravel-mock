<?php

return [
    "route" => "mock",
    "path" => "mock",
    "condition" => function(){
        return app()->isLocal();
    }
];
