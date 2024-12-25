<?php

return [
    /*
        |--------------------------------------------------------------------------
        | Login code Lifetime
        |--------------------------------------------------------------------------
        |
        |   This variable represents the lifetime of the code sent for logging
        |   into the system. Its value is in minutes.
        |
    */

    'file' => [
        'memes' => 'png,bmp,gif,jpg,jpeg,zip,rar,mp3,mp4,pdf,xlsx,xls,csv,doc,docx',
        'memes-sheet' => 'xlsx,xls,csv',
        'memes-image' => 'png,bmp,gif,jpg,jpeg',
        'memes-compress' => 'zip,rar',
        'memes-document' => 'csv,doc,docx',
        'memes-media' => 'png,jpg,jpeg,mp3,mp4,pdf',
    ],
    /*
     * -------------------------------------------
     * All values below are based on minutes
     * -------------------------------------------
     * */
    'cache' => [
        'timeout-a-day' => 1439, // equal = 24h
        'timeout-half-a-day' => 719, // 12h
        'timeout-long' => 479, // 8h
        'timeout-medium' => 239, // 4h
        'timeout-short' => 59, // 1h
        'timeout-15min' => 15, // 15m
    ],
    'config' => [
        'per_page' => 20,
    ],
    'super_admin_user' => [
        'username' => env('SUPERADMINUSER_USERNAME', 'admin@pars.com'),
        'password' => env('SUPERADMINUSER_PASSWORD', '1234567890'),
    ],
];
