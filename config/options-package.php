<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Options enabled
    |--------------------------------------------------------------------------
    |
    | When you disable this package, no data from the default configuration
    | will be replaced with data from the database.
    |
    | Default configuration file location is /config/options.php
    |
    | When you change this setting, you must restore the cache!
    |
    */
    'enabled' => env('USER_OPTIONS', true),

    /*
    |--------------------------------------------------------------------------
    | Options replaced only in production mode
    |--------------------------------------------------------------------------
    |
    | You can set the replacement of data from the default configuration
    | for production mode only.
    |
    | true = replace from the database only in production mode
    | false = always replace from the database
    |
    | Default configuration file location is /config/options.php
    |
    | When you change this setting, you must restore the cache!
    |
    */
    'only-in-production' => false,

    /*
    |--------------------------------------------------------------------------
    | Options cache name
    |--------------------------------------------------------------------------
    |
    | Options are cached by file driver. You can set the key for cache.
    |
    | When you change this setting, you must restore the cache!
    |
    */
    'cache-name' => 'keniley-options',

    /*
    |--------------------------------------------------------------------------
    | Options auto observe
    |--------------------------------------------------------------------------
    |
    | When you updete (or create) some data in model, package automatically 
    | refresh cache. You can turn off this behavior, but remember that you must 
    | manually refresh the cache.
    |
    */
    'auto-observe' => true,

    /*
    |--------------------------------------------------------------------------
    | Options data types
    |--------------------------------------------------------------------------
    |
    | Change the value data type. 
    | If no function is defined for any type, it will be returned as a string.
    |
    | If you have the auto-observe option enabled, you cannot save an undefined type!
    |
    */
    'types' => [

        'string' => function($data) { 
            return (string) $data['value']; 
        },

        'integer' => function($data) { 
            return (int) $data['value']; 
        },

        'float' => function($data) { 
            return (float) $data['value']; 
        },

        'boolean' => function($data) { 
            return (bool) $data['value']; 
        },

        'json' => function($data) { 
            return json_decode($data['value']); 
        },

        'array' => function($data) { 
            return json_decode($data['value'], true); 
        },

        'datetime' => function($data) { 
            return new \DateTime($data['value']); 
        },

        'carbon' => function($data) {
            return \Carbon\Carbon::create($data['value']);
        }
    ]
];