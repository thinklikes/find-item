<?php


namespace App\Endpoints;

use GuzzleHttp\Psr7\Request;

class NailLabo implements Endpoint
{
    const URL    = 'https://www.naillabotw.com/product';
    const URI    = 'https://www.naillabotw.com/api';
    const BODY   = '{"query":"query ProductList($search: searchInputObjectType) {\n      computeProductList(\n        search: $search\n      ) {\n        data {\n          id\n          title {\n            zh_TW\n            en_US\n          }\n          description {\n            zh_TW\n            en_US\n          }\n          variants {\n            id\n            stock\n            listPrice\n            suggestedPrice\n            totalPrice\n          }\n          coverImage {\n            fileId\n            src\n          }\n          showUserPrice {\n            showListPrice\n            showSuggestedPrice\n          }\n        }\n        total\n      }\n    }","variables":{"search":{"size":100,"from":0,"filter":{"and":[{"type":"exact","field":"status","query":1}],"or":[{"type":"query_string","child":"variant","fields":["sku","vendorSku"],"query":"{search_text}"},{"type":"query_string","fields":["title.zh_TW"],"query":"{search_text}"}]},"sort":[{"field":"createdOn","order":"desc"}],"showVariants":true,"showMainFile":true}}}';
    const METHOD = 'POST';
    const NAME   = 'Nail Labo';

    public function generateRequest(string $searchText): Request
    {
        return new Request(
            self::METHOD,
            self::URI,
            ['Content-Type' => 'application/json'],
            str_replace('{search_text}', $searchText, self::BODY)
        );
    }

    /**
     * @param string $html
     * @return array
     */
    public function analyze(string $contents): array
    {
        $result = [];

        $data = json_decode($contents, true)['data']['computeProductList']['data'];

        foreach ($data as $resource) {
            $result[] = [
                'image' => '<img height="160" width="160" src="' . $resource['coverImage']['src'] . '">',
                'name'  => $resource['title']['zh_TW'],
                'uri'   => self::URL . "/" . $resource['id'],
                'note'  => $resource['description']['zh_TW'],
            ];

        }

        return $result;
    }

}
