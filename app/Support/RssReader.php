<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class RssReader
{
    private $contents;

    public function setPath($path)
    {
        $data = Http::get($path);

        if (!$data) {
            return false;
        }

        try {
            $simpleXML = new SimpleXMLElement($data);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }

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
