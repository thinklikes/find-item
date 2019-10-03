<?php


namespace App\Endpoints;


abstract class HtmlParser implements Endpoint
{
    const DELIMITER       = '/';
    const PREG_ANY_CHARS  = '(?>[^\<]*)';
    const PREG_ANY_SPACES = '(?>\s*)';

    protected function tagPattern(string $tag, array $attributes = [], string $inner = '', $onlyLeft = false)
    {
        $pattern = "\<$tag";

        foreach ($attributes as $key => $value) {
            $pattern .= "(?>[^<]*$key=(?:\"|\')?$value(?:\"|\')?)";
        }

        return $pattern . '(?>[^<]*\>)' . $inner . ($onlyLeft ? "" : "\<\/$tag\>");

    }
}
