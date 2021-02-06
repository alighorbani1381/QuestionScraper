<?php

namespace App\DomParser;

use Src\DOM\DOMInterface;
use PhpTool\Vardumper\Debug;
use Sunra\PhpSimple\HtmlDomParser;

class SingleQuestionParser implements DOMInterface
{
    const INDEX_OF_ELEMENT = 0;

    public $dom;

    public $content = [];

    public function __construct($html)
    {
        $this->dom = HtmlDomParser::str_get_html($html);
    }

    public function getInfo()
    {
        $this->setQuestion();

        $this->setAnswer();

        $this->setOption();

        return $this->content;
    }

    public function setQuestion()
    {
        $questionsParagraphs = $this->dom->find('div[id=answerContent]>p');

        $questionItem = [];

        foreach ($questionsParagraphs as $questionsParagraph) {
            $questionItem[] =  $questionsParagraph->plaintext;
        }

        $questionText = ($questionItem[0] . $questionItem[1]);

        $this->content['question'] = $this->convertToHumanText($questionText);
    }

    public function setAnswer()
    {
        $answer = $this->dom->find('div[id=answerContent]', self::INDEX_OF_ELEMENT)->plaintext;

        $this->content['answer'] = $this->convertToHumanText($answer);
    }

    public function setOption()
    {
        // Set Question Item of Question
        foreach ($this->dom->find('table td') as $key => $item) {
            $this->content['item'][] = $this->convertToHumanText($item->plaintext);
        }

        // remove last param extra
        array_pop($this->content['item']);
    }
    public function convertToHumanText($htmlText)
    {
        $converted = strtr($htmlText, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES)));

        return trim(trim($converted, chr(0xC2) . chr(0xA0)));
    }
}
