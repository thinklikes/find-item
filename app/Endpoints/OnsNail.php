<?php


namespace App\Endpoints;

use GuzzleHttp\Psr7\Request;

class OnsNail extends HtmlParser
{
    const URL    = 'https://www.onsnail.com.tw/';
    const URI    = 'https://www.onsnail.com.tw/products_search.htm';
    const METHOD = 'POST';
    const NAME   = 'ONS 美甲學苑&暢貨中心';

    public function generateRequest(string $searchText): Request
    {
        return new Request(
            self::METHOD,
            self::URI,
            [
                'content-Type' => 'application/x-www-form-urlencoded'
            ],
            http_build_query(['PdSearch' => $searchText], null, '&')
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
                'image' => '<img height="160" width="160" src="' . self::URL . $this->findImage($resource) . '">',
                'name'  => isset($parts[1]) ? $parts[1] : '',
                'uri'   => isset($parts[0]) ? $parts[0] : '',
                'note'  => '',
            ];

        }

        return $result;
    }

    protected function findResources(string $html)
    {
        $pattern = $this->tagPattern('li', ['class' => 'item'], '');

        preg_match_all(self::DELIMITER . $pattern . self::DELIMITER . 'is', $html, $matches);

        return $matches[0];
    }

    /**
     * @param string $resource
     * @return string
     */
    protected function findImage(string $resource): string
    {
        $pattern = $this->tagPattern('img', ['src' => '([\w\/\.]+)'], '', false, true);

        preg_match(self::DELIMITER . $pattern . self::DELIMITER . 'is', $resource, $matches);

        return isset($matches[1]) ? $matches[1] : '';
    }

    /**
     * @param string $resource
     * @return array|string[]
     */
    protected function findItemAndUrl(string $resource): array
    {
        $pattern = $this->tagPattern(
            'a',
            ['href' => '([\w\/:\.?=]+)', 'class' => 'txt'],
            $this->concat(
                $this->tagPattern('div'),
                $this->tagPattern('div')
            ),
            false
        );

        preg_match(self::DELIMITER . $pattern . self::DELIMITER . 'is', $resource, $matches);

        array_shift($matches);
        array_pop($matches);

        return $matches ?: [];

    }

}
