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
        'access_token' => env('AOD_TRACKER_TOKEN', ''),
        'announcements_rss_feed' => env('ANNOUNCEMENTS_RSS_FEED'),
        'tracker_url' => env('TRACKER_URL', '//tracker.clanaod.net'),
        'twitter_rss_feed' => env('TWITTER_RSS_FEED'),
        'max_announcements' => env('MAX_FOOTER_ANNOUNCEMENTS', 4),
    ],

    'twitter' => [
        'auth' => [
            'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        ],

        'stream_config' => [
            'screen_name' => 'officialclanaod',
            'count' => 5,
            'trim_user' => true,
            'exclude_replies' => true,
            'include_rts' => true,
        ],
    ],

    'twitch' => [
        'client_id' => env('TWITCH_CLIENT_ID'),
        'client_secret' => env('TWITCH_CLIENT_SECRET'),
        'channel' => env('TWITCH_CHANNEL', 'clanaodstream'),
        'api_base' => 'https://api.twitch.tv/helix',
        'oauth_url' => 'https://id.twitch.tv/oauth2/token',
    ],

];
