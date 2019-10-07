<?php


namespace App\Endpoints;

use GuzzleHttp\Psr7\Request;

class OstarNails implements Endpoint
{
    const URL    = 'http://www.ostar-nails.com/SalePage/Index/';
    const URI    = 'http://www.ostar-nails.com/webapi/SearchV2/GetShopSalePageBySearch?keyword={search_text}&lang=zh-TW';
    const METHOD = 'GET';
    const NAME   = '心緹 Ostar';

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

        $data = json_decode($contents, true)['Data']['SalePageList'];

        foreach ($data as $resource) {
            $result[] = [
                'image' => '<img height="160" width="160" src="' . $resource['PicUrl'] . '">',
                'name'  => $resource['Title'],
                'uri'   => self::URL . $resource['Id'],
                'note'  => '',
            ];

        }

        return $result;
    }

}
