<?php

namespace Tests\Feature;

use App\Services\AlphaVantageApiService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test web routes return correct status responses
 *
 * @package Tests\Feature
 */
class RoutesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test web routes work
     *
     * @return void
     */
    public function testRoutes()
    {
        $response = $this->get('/');
        $response->assertStatus(Response::HTTP_OK);

        $response = $this->get('auth/facebook');
        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->get('logout');
        $response->assertStatus(Response::HTTP_FOUND);

        // Without login
        $response = $this->get('stocks');
        $response->assertStatus(Response::HTTP_FOUND);

        // Logged User
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/stocks');
        $response->assertStatus(Response::HTTP_OK);
    }

}
