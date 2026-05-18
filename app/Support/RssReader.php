<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class RssReader
{
    private ?SimpleXMLElement $contents = null;

    public function setPath(string $path): static|false
    {
        $response = Http::get($path);

        if (! $response->successful()) {
            return false;
        }

        try {
            $simpleXML = new SimpleXMLElement($response->body());
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }

        if (! property_exists($simpleXML, 'channel')) {
            return false;
        }

        $this->contents = $simpleXML->channel;

        return $this;
    }

    public function getItems(): ?SimpleXMLElement
    {
        return $this->contents;
    }

    public function getLastBuilt(): mixed
    {
        return $this->contents?->lastBuildDate;
    }
}
