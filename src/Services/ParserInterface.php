<?php

namespace Toanlt\Crawler\Services;

interface ParserInterface
{
    /**
     * @return array|null
     */
    public function parse(): ?array;
}