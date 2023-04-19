<?php

namespace Toanlt\Crawler\Factories;

use Exception;
use Toanlt\Crawler\Services\DanTriParser;
use Toanlt\Crawler\Services\ParserInterface;
use Toanlt\Crawler\Services\VietNamNetParser;
use Toanlt\Crawler\Services\VnExpressParser;

class ParserFactory
{
    /**
     * @throws Exception
     */
    public static function make(string $url): ParserInterface
    {
        return match (true) {
            str_contains($url, "dantri.com.vn") => new DantriParser(
                $url,
                'title-page detail',
                'singular-content p',
                'date'
            ),
            str_contains($url, "vietnamnet.vn") => new VietnamnetParser(
                $url,
                'content-detail-title',
                'maincontent',
                'bread-crumb-detail__time'
            ),
            str_contains($url, "vnexpress.net") => new VnexpressParser(
                $url,
                'title-detail',
                'fck_detail',
                'date'
            ),
            default => throw new Exception('Invalid parser type'),
        };
    }
}