<?php
namespace Tests\Controller;

use App\Services\AlphaVantageApiService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlphaVantageApiTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test usual valid case
     *
     * @return void
     */
    public function testValidCase()
    {
        $this->mock(AlphaVantageApiService::class, function ($mock) {
            return $mock->shouldReceive('querySymbol')
                ->once()
                ->andReturn(new \GuzzleHttp\Psr7\Response(
                    Response::HTTP_OK,
                    [],
                    '{
                        "Global Quote": {
                            "01. symbol": "AMZN",
                            "02. open": "3185.5600",
                            "03. high": "3228.8600",
                            "04. low": "3183.0000",
                            "05. price": "3222.9000",
                            "06. volume": "3325022",
                            "07. latest trading day": "2021-05-14",
                            "08. previous close": "3161.4700",
                            "09. change": "61.4300",
                            "10. change percent": "1.9431%"
                        }
                    }'
                ));
        });

        $response = $this->getJson('api/stock-quotes?symbol=AMZN');
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'id' => 1,
            'symbol' => 'AMZN',
            'high' => "3228.8600",
            'low' => "3183.0000",
            'price' => "3222.9000",
        ]);
    }


    /**
     * Test no result case
     *
     * @return void
     */
    public function testNoResult()
    {
        $this->mock(AlphaVantageApiService::class, function ($mock) {
            return $mock->shouldReceive('querySymbol')
                ->once()
                ->andReturn(new \GuzzleHttp\Psr7\Response(
                    Response::HTTP_OK,
                    [],
                    '{
                        "Global Quote": {}
                    }'
                ));
        });

        $response = $this->get('api/stock-quotes?symbol=123');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertExactJson([]);
    }


    /**
     * Test 'no symbol sent' case
     *
     * @return void
     */
    public function testNoSymbol()
    {
        $response = $this->getJson('api/stock-quotes');
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Test 'too much requests to the API' case
     *
     * @return void
     */
    public function testTooMuchRequest()
    {
        $this->mock(AlphaVantageApiService::class, function ($mock) {
            return $mock->shouldReceive('querySymbol')
                ->once()
                ->andReturn(new \GuzzleHttp\Psr7\Response(
                    Response::HTTP_OK,
                    [],
                    '{"Note": "Thank you for using Alpha Vantage! Our standard API call frequency is 5 calls per minute and 500 calls per day. Please visit https://www.alphavantage.co/premium/ if you would like to target a higher API call frequency."}'
                ));
        });

        $response = $this->getJson('api/stock-quotes?symbol=AMZN');
        $response->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
        $response->assertJson([
            'message' => 'Too many requests. Please try again later',
        ]);
    }
}
