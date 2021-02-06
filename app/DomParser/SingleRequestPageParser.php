<?php

namespace App\DomParser;

use Src\DOM\DOMInterface;
use PhpTool\Vardumper\Debug;
use Sunra\PhpSimple\HtmlDomParser;

class SingleRequestPageParser implements DOMInterface
{
    const INDEX_OF_FIRST_ELEMENT = 0;

    public $dom;

    public $content = [];

    public function __construct($html)
    {
        $this->dom = HtmlDomParser::str_get_html($html);
    }

    public function getInfo()
    {
        $formTag = $this->dom->find("form[id=loginForm]", self::INDEX_OF_FIRST_ELEMENT);

        return $this->elementExists($formTag);
    }

    public function elementExists($element)
    {
        return (is_object($element));
    }
}
