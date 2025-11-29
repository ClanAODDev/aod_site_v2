<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class RssReader
{
    private $contents;

    public function setPath($path)
    {
        $response = Http::get($path);

        if (! $response->successful()) {
            return false;
        }

        $data = $response->body();

        try {
            $simpleXML = new SimpleXMLElement($data);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());

            return false;
        }

        if (! property_exists($simpleXML, 'channel')) {
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
