<?php


namespace App\Endpoints;

use GuzzleHttp\Psr7\Request;

class Ruyiya extends HtmlParser
{
    const URL    = 'https://ruyiya.shop2000.com.tw';
    const URI    = 'https://ruyiya.shop2000.com.tw/product/kw={search_text}';
    const METHOD = 'GET';

    public function generateRequest(string $searchText): Request
    {
        return new Request(
            self::METHOD,
            str_replace('{search_text}', htmlentities($searchText), self::URI),
            );
    }

    /**
     * @param string $html
     * @return array
     */
    public function analyze(string $html): array
    {
        $result = [];

        foreach ($this->findResources($html) as $resource) {
            $parts    = $this->findItemAndUrl($resource);
            $result[] = [
                'image' => $this->findImage($resource),
                'name'  => isset($parts[1]) ? $parts[1] : '',
                'uri'   => isset($parts[0]) ? self::URL . $parts[0] : '',
                'note'  => $this->findNote($resource),
            ];

        }

        return $result;
    }

    protected function findResources(string $html)
    {
        $pattern = $this->tagPattern(
            'td',
            [],
            $this->tagPattern(
                'table',
                ['class' => 'p_tb'],
                self::PREG_ANY_CHARS . '(?>\<(?!\/table\>)[^\<]*)*'
            ),
            true
        );
        $pattern .= $this->tagPattern(
            'td',
            [],
            $this->tagPattern(
                'ul',
                ['class' => 'p_ul'],
                self::PREG_ANY_CHARS . '(?>\<(?!\/ul\>)[^\<]*)*'
            ) . "(?:" . $this->tagPattern(
                'div',
                ['class' => 'pd_l'],
                self::PREG_ANY_CHARS . '(?>\<(?!\/div\>)[^\<]*)*'
            ) . ")?",
            true,
            );
        preg_match_all(self::DELIMITER . $pattern . self::DELIMITER . 'is', $html, $matches);

        return $matches[0];
    }

    /**
     * @param string $resource
     * @return string
     */
    protected function findImage(string $resource): string
    {
        $pattern = '\<img(?>[^<]*\>)';

        preg_match(self::DELIMITER . $pattern . self::DELIMITER . 'is', $resource, $matches);

        return isset($matches[0]) ? $matches[0] : '';
    }

    /**
     * @param string $resource
     * @return array|string[]
     */
    protected function findItemAndUrl(string $resource): array
    {
        $pattern = $this->tagPattern('li', [],
            $this->tagPattern('a', ['href' => '(\/product\/p\d+)'], '&nbsp;(' . self::PREG_ANY_CHARS . ')')
        );

        preg_match(self::DELIMITER . $pattern . self::DELIMITER . 'is', $resource, $matches);

        array_shift($matches);

        return $matches ?: [];

    }


    protected function findNote(string $resource)
    {
        $pattern = $this->tagPattern('div', ['class' => 'pd_l'],
            '(' . self::PREG_ANY_CHARS . '(?>\<(?!\/div\>)[^\<]*)*)');

        preg_match(self::DELIMITER . $pattern . self::DELIMITER . 'is', $resource, $matches);

        return isset($matches[1]) ? $matches[1] : '';
    }

}
