<?php

/**
 * @return mixed
 */
function urlify($string)
{
    $regex = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    return (preg_match($regex, $string, $url))
        ? preg_replace($regex, "<a href=\"{$url[0]}\" target=\"_blank\">{$url[0]}</a> ", $string)
        : $string;
}
