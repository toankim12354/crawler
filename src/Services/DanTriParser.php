<?php

namespace Toanlt\Crawler\Services;

class DanTriParser extends BaseParser
{
    /**
     * @param string $url
     * @param string $titleSelector
     * @param string $contentSelector
     * @param string $dateSelector
     */
    public function __construct(string $url, string $titleSelector, string $contentSelector, string $dateSelector)
    {
        parent::__construct($url, $titleSelector, $contentSelector, $dateSelector);
    }
}