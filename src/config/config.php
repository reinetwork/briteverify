<?php

return [

    /*
    |--------------------------------------------------------------------------
    | BriteVerify API Access Token
    |--------------------------------------------------------------------------
    |
    | The API access token provided to you on creating a BriteVerify account.
    |
    */

    'token' => null,


    /*
    |--------------------------------------------------------------------------
    | BriteVerify Pretend flag
    |--------------------------------------------------------------------------
    |
    | When in local or testing, this flag will be true. Otherwise, for staging, and prod,
    | it will be false.
    |
    */

    'pretend' => env('APP_ENV') == 'local' || env('APP_ENV') == 'testing' ? true : false,

];
