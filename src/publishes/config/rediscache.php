<?php

return [
    'connections' => [
        [
            /**
             * The scheme which will be used to connect to the redis client.
             */
            'scheme' => 'tcp',

            /**
             * The host for redis to connect
             */
            'host' => env('REDIS_HOST', '127.0.0.1'),

            /**
             * Port for the connection
             */
            'post' => env('REDIS_PORT', 6379),
        ]
    ]
];
