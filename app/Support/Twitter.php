<?php

namespace App\Support;

use TwitterAPIExchange;

class Twitter
{
    private $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

    public function getfeed()
    {
        $config = config('services.twitter');
        $twitter = new TwitterAPIExchange($config['auth']);

        return json_decode(
            $twitter->setGetfield(http_build_query($config['stream_config']))
                ->buildOauth($this->url, 'GET')
                ->performRequest([
                    'CURLOPT_TIMEOUT' => 3
                ])
        );
    }
}
