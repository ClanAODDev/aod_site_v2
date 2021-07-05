<?php

namespace App\Support;

use SimpleXMLElement;

class RssReader
{
    private $contents;

    public function setPath($path)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $data = curl_exec($ch);

        if (!$data) {
            return false;
        }

        $simpleXML = new SimpleXMLElement($data);

        if (!property_exists($simpleXML, 'channel')) {
            return false;
        }

        $this->contents = $simpleXML->channel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->contents;
    }

    /**
     * @return mixed
     */
    public function getLastBuilt()
    {
        return $this->contents->lastBuildDate;
    }
}