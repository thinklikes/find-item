<?php


namespace App\Endpoints;


abstract class HtmlParser implements Endpoint
{
    const DELIMITER       = '/';
    const PREG_ANY_CHARS  = '(?>[^<]*)';
    const PREG_ANY_SPACES = '(?>\s*)';

    protected function tagPattern(string $tag, array $attributes = [], string $inner = '', $containAnyTag = true, $onlyLeft = false)
    {
        $pattern = "<$tag";

        foreach ($attributes as $key => $value) {
            $pattern .= "(?>[^<]*$key=(?:\"|\')?$value(?:\"|\')?)";
        }

        return $pattern . '(?>[^<]*>)' .
            "(" .
                self::PREG_ANY_CHARS .
                ($containAnyTag ? "(?><(?!\/$tag>)[^<]*)*" : "") .
                $inner .
            ")" .
            ($onlyLeft ? "" : "<\/$tag>")  . self::PREG_ANY_CHARS;

    }

    /**
     * @param mixed|string[] ...$elements
     * @return string
     */
    protected function concat(...$elements) {
        if (is_array($elements)) {
            return implode(self::PREG_ANY_SPACES, $elements);
        }
        return $elements;
    }
}
