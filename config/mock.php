<?php

return [
    "route" => "api-mock", // Default route path of the mock api
    "path" => "storage/mock", // Default folder path of the mock api
    "paginate" => true, // Define if we must paginate the results or not
    "per_page" => 10, // Define the number of items per page (if paginate = true)
    "condition" => function(){ // The condition to define if the mock routing is enabled or not
        return app()->isLocal();
    },
    "force_json" => true, // Force the whole mock controller to render application/json
    "entrypoints" => [ // instead of looking into a folder you can also run a factory($class$, $number$)->states($state$)->make($override$) or add validation on controller method
        /*"users" => [
            "class" => \App\User::class, // if null factory won't be triggerred
            "number" => 100, // number of factory to run
            "states" => [],
            "override" => [],
            "update_validation" => [
                "name" => "required"
            ],
            "update_force_json" => false,
            "index_force_json" => false,
            "store_validation" => \App\Http\Requests\UserPostRequest::class
        ]*/
    ]
];
