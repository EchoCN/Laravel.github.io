<?php
/**
 * Created by PhpStorm.
 * User: dd
 * Date: 2018/6/6
 * Time: 21:09
 */

namespace App\Markdown;

class Markdown
{
    protected $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }
    public function markdown($text)
    {
        $html = $this->parser->makeHtml($text);
        return $html;
    }
}