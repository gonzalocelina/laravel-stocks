<?php
namespace App\Services;

use GuzzleHttp\Client;

class AlphaVantageApiService
{
    private $url = 'https://www.alphavantage.co/query';

    /**
     * Queries the AlphaVantage API for a stock symbol
     *
     * @param $symbol
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function querySymbol($symbol)
    {
        $client = new Client();
        return $client->get($this->url, [
            'query' => [
                'function' => 'GLOBAL_QUOTE',
                'symbol' => $symbol,
                'apikey' => env('AV_API_KEY'),
            ],
        ]);
    }
}
