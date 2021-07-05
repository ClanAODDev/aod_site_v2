<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'aod' => [
        'access_token' => env('AOD_TRACKER_TOKEN'),
        'announcements_rss_feed' => env('ANNOUNCEMENTS_RSS_FEED'),
        'tracker_url' => env('TRACKER_URL', '//tracker.clanaod.net')
    ],

    'twitter' => [
        'auth' => [
            'oauth_access_token' => env('oauth_access_token'),
            'oauth_access_token_secret' => env('oauth_access_token_secret'),
            'consumer_key' => env('consumer_key'),
            'consumer_secret' => env('consumer_secret'),
        ],

        'stream_config' => [
            'screen_name' => 'officialclanaod',
            'count' => 5,
            'trim_user' => true,
            'exclude_replies' => true,
            'include_rts' => true,
        ],
    ],

];
