<?php

namespace Toanlt\Crawler\Services;
/**
 * @package Toanlt\Crawler\Services
 */
class VietNamNetParser extends BaseParser
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