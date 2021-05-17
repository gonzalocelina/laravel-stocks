<?php

namespace App\Http\Controllers;

use App\Services\AlphaVantageApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\StockQuote;
use Illuminate\Http\Response;

class AlphaVantageApiController extends Controller
{
    /**
     * Creates and returns a new StockQuote
     *
     * @param Request $request
     * @param AlphaVantageApiService $apiService
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|Response|\Psr\Http\Message\ResponseInterface
     */
    public function getStockQuote(Request $request, AlphaVantageApiService $apiService) {
        $symbol = $request->get('symbol');
        if (!$symbol) {
            return response('{"message": "Symbol field can\'t be null"}', Response::HTTP_BAD_REQUEST);
        }
        $response = $apiService->querySymbol($symbol);

        if ($response->getStatusCode() != Response::HTTP_OK) {
            return $response;
        }

        $bodyStdClass = json_decode($response->getBody());
        // As we're using the free version there's a limit to how many request we can do
        if (!property_exists($bodyStdClass, "Global Quote")) {
            return response('{"message": "Too many requests. Please try again later"}', Response::HTTP_TOO_MANY_REQUESTS);
        }

        $stockData = (array) $bodyStdClass->{"Global Quote"};

        if (empty($stockData)) {
            return new JsonResponse([]);
        }

        $symbol = $stockData["01. symbol"];
        $high = $stockData["03. high"];
        $low = $stockData["04. low"];
        $price = $stockData["05. price"];
        $stockQuote = StockQuote::create([
            'symbol' => $symbol,
            'high' => $high,
            'low' => $low,
            'price' => $price,
        ]);

        return $stockQuote;
    }
}
