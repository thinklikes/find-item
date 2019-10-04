<?php


namespace App\Endpoints;

use GuzzleHttp\Psr7\Request;

class HcNails extends HtmlParser
{
    const URL    = 'https://www.hcnails.com/ecommerce/';
    const URI    = 'https://www.hcnails.com/ecommerce/catalogsearch/result/index/?limit=100&mode=list&q={search_text}';
    const METHOD = 'GET';
    const NAME   = '康盟國際';

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
        $pattern = $this->concat(
            $this->tagPattern('a', [], ''),
            '<div class="product-shop">',
            '<div class="f-fix">',
            $this->tagPattern('div', ['class' => 'product-primary']),
            $this->tagPattern(
                'div',
                ['class' => 'product-secondary'],
                $this->tagPattern('div', ['class' => 'price-box']),
                false
            ),
            $this->tagPattern('div', ['class' => 'product-secondary']),
            $this->tagPattern('div', ['class' => 'desc std'])

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
        $pattern = $this->tagPattern(
            'h2',
            ['class' => 'product-name'],
            $this->tagPattern('a', ['href' => preg_quote(self::URL, self::DELIMITER) . '([^<>"\']*\.html)'], '', false),
            false
        );
        preg_match(self::DELIMITER . $pattern . self::DELIMITER . 'is', $resource, $matches);

        array_shift($matches);
        array_shift($matches);

        return $matches ?: [];

    }


    protected function findNote(string $resource)
    {
        $pattern = $this->tagPattern('div', ['class' => 'desc std']);

        preg_match(self::DELIMITER . $pattern . self::DELIMITER . 'is', $resource, $matches);

        return isset($matches[1]) ? $matches[1] : '';
    }

}
