<?php

namespace Toanlt\Crawler\Services;

class VnExpressParser extends BaseParser
{
    public function __construct(string $url, string $titleSelector, string $contentSelector, string $dateSelector)
    {
        parent::__construct($url, $titleSelector, $contentSelector, $dateSelector);
    }
}