<?php

namespace Toanlt\Crawler\Services;
/**
 * @package Toanlt\Crawler\Services
 */
class VnExpressParser extends BaseParser
{
    /**
     * @var string
     */
    public function __construct(string $url, string $titleSelector, string $contentSelector, string $dateSelector)
    {
        parent::__construct($url, $titleSelector, $contentSelector, $dateSelector);
    }
}