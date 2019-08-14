<?php

return [
    "route" => "api-mock", // Default route path of the mock api
    "path" => "mock", // Default folder path of the mock api
    "paginate" => true, // Define if we must paginate the results or not
    "per_page" => 1, // Define the number of items per page (if paginate = true)
    "condition" => function(){ // The condition to define if the mock routing is enabled or not
        return app()->isLocal();
    }
];
