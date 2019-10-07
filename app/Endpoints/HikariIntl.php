<?php


namespace App\Endpoints;

use GuzzleHttp\Psr7\Request;

class HikariIntl implements Endpoint
{
    const URL    = 'http://hikari-intl.com/';
    const URI    = 'http://hikari-intl.com/wp-admin/admin-ajax.php?action=flatsome_ajax_search_products&query={search_text}';
    const METHOD = 'GET';
    const NAME   = '官庭國際';

    public function generateRequest(string $searchText): Request
    {
        return new Request(
            self::METHOD,
            str_replace('{search_text}', $searchText, self::URI),
            ['Content-Type' => 'application/json'],
        );
    }

    /**
     * @param string $html
     * @return array
     */
    public function analyze(string $contents): array
    {
        $result = [];

        $data = json_decode($contents, true)['suggestions'];

        foreach ($data as $resource) {
            $result[] = [
                'image' => '<img height="160" width="160" src="' . $resource['img'] . '">',
                'name'  => $resource['value'],
                'uri'   => $resource['url'],
                'note'  => '',
            ];

        }

        return $result;
    }

}
