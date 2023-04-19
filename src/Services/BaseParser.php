<?php

namespace Toanlt\Crawler\Services;

use DOMDocument;
use DOMNode;
use DOMXPath;


abstract class  BaseParser implements ParserInterface
{
    protected string $url;
    protected string $titleSelector;
    // get class content from dan tri
    protected string $contentSelector;
    // get class date from dan tri
    protected string $dateSelector;

    /**
     * @param string $url
     * @param string $titleSelector
     * @param string $contentSelector
     * @param string $dateSelector
     */
    protected function __construct(string $url, string $titleSelector, string $contentSelector, string $dateSelector)
    {
        $this->url = $url;
        $this->titleSelector = $titleSelector;
        $this->contentSelector = $contentSelector;
        $this->dateSelector = $dateSelector;
    }


    /**
     * @return array|null
     */
    public function parse(): ?array
    {
        $html = $this->getHtml();

        if (!empty($html)) {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();

            $title = $this->getElementsByClass($this->titleSelector);
            $content = $this->getElementsByClass($this->contentSelector);
            $date = $this->getElementsByClass($this->dateSelector);

            return [
                'title' => $title,
                'content' => $content,
                'date' => $date
            ];
        }

        return null;
    }

    /**
     * @return string
     */
    protected function getHtml(): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $html = curl_exec($ch);

        curl_close($ch);

        return $html;
    }

    /**
     * get class check html document
     * @param string $class
     * @return string|null
     */
    protected function getElementsByClass(string $class): ?string
    {
        $html = $this->getHtml();

        if (!empty($html)) {
            $dom = new DOMDocument();

            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();

            $finder = new DomXPath($dom);
            $node = $finder->query("//*[contains(@class, '$class')]")->item(0);

            if ($node) {
                return $this->innerHTML($node);
            }
        }

        return null;
    }

    /**
     * get the innerHTML of a node
     *
     * @param DOMNode $node
     * @return string
     */
    protected function innerHTML(DOMNode $node): string
    {
        return strip_tags(
            implode(array_map([$node->ownerDocument, "saveHTML"], iterator_to_array($node->childNodes)))
        );
    }
}