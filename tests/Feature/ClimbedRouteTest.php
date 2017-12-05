<?php

namespace Tests\Feature;

use App\ClimbedRoute;
use App\ClimbSession;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClimbedRouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        \Auth::login($this->user);
    }

    public function testClimbedRouteStore()
    {
        $climb = factory(ClimbSession::class)->create(['user_id' => $this->user->id]);
        $climbedRouteDummy = factory(ClimbedRoute::class)->make();

        $response = $this->createRoute($climbedRouteDummy, $climb->id);
        $response
            ->assertJsonStructure(['id'])
            ->assertSuccessful();

        $climbedRoute = ClimbedRoute::find($response->original['id']);
        $this->assertNotNull($climbedRoute);
        $this->assertNotNull($climbedRoute->climb_session_id);
        $this->assertRouteArrayEqualObject($climbedRoute, $climbedRouteDummy);
    }

    public function testClimbedRouteUpdate()
    {
        $climb = factory(ClimbSession::class)->create(['user_id' => $this->user->id]);
        $climbedRoute = $climb->climbedRoutes()
            ->save(factory(ClimbedRoute::class)->make())
            ->first();

        $this->assertNotNull($climbedRoute->climb_session_id);

        $nameToUpdate = 'asd';
        $response = $this->putJson('/api/climbed-routes/' . $climbedRoute->id, [
            'name' => $nameToUpdate,
            'category_dict' => $climbedRoute->category_dict,
            'proposed_category_dict' => $climbedRoute->proposed_category_dict,
        ]);
        $response->assertSuccessful();

        $this->assertEquals($nameToUpdate, ClimbedRoute::find($climbedRoute->id)->name);
    }

    public function testClimbedRouteUpdateFailForNotOwner()
    {
        $climb = factory(ClimbSession::class)->create(['user_id' => 999]);
        $climbedRoute = $climb->climbedRoutes()
            ->save(factory(ClimbedRoute::class)->make())
            ->first();

        $this->putJson('/api/climbed-routes/' . $climbedRoute->id, [
            'name' => 123,
            'category_dict' => $climbedRoute->category_dict,
            'proposed_category_dict' => $climbedRoute->proposed_category_dict,
        ])->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testClimbedRouteCreateFailForNotOwner()
    {
        $climb = factory(ClimbSession::class)->create(['user_id' => 999]);
        $climbedRoute = factory(ClimbedRoute::class)->make(['climb_session_id' => $climb->id]);

        $this->createRoute($climbedRoute, $climbedRoute->climb_session_id)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testClimbedRouteCreateFailForNotExistedClimbSession()
    {
        $climbedRoute = factory(ClimbedRoute::class)->make(['climb_session_id' => 9999]);

        $this->createRoute($climbedRoute, $climbedRoute->climb_session_id)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testClimbedRouteGet()
    {
        $climb = factory(ClimbSession::class)->create(['user_id' => $this->user->id]);
        $climbedRoute = $climb->climbedRoutes()->save(factory(\App\ClimbedRoute::class)->make());

        $response = $this->getJson('/api/climbed-routes/' . $climbedRoute->id);
        $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'category_dict',
                    'proposed_category_dict',
                    'route_type_dict',
                    'ascent_type_dict',
                ]
            ]);

        $climbedRouteData = $response->original['data'];
        $this->assertRouteArrayEqualObject($climbedRouteData, $climbedRoute);
    }

    /**
     * @param array|ClimbedRoute $actual
     * @param ClimbedRoute $expected
     */
    private function assertRouteArrayEqualObject($actual, ClimbedRoute $expected)
    {
        $this->assertEquals($actual['name'], $expected->name);
        $this->assertEquals($actual['category_dict'], $expected->category_dict);
        $this->assertEquals($actual['proposed_category_dict'], $expected->proposed_category_dict);
        $this->assertEquals($actual['route_type_dict'], $expected->route_type_dict);
        $this->assertEquals($actual['ascent_type_dict'], $expected->ascent_type_dict);
    }

    /**
     * @param ClimbedRoute $climbedRoute
     * @param int $climbSessionId
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function createRoute(ClimbedRoute $climbedRoute, int $climbSessionId)
    {
        return $this->postJson('/api/climbed-routes', [
            'name' => $climbedRoute->name,
            'climb_session_id' => $climbSessionId,
            'category_dict' => $climbedRoute->category_dict,
            'proposed_category_dict' => $climbedRoute->proposed_category_dict,
            'route_type_dict' => $climbedRoute->route_type_dict,
            'ascent_type_dict' => $climbedRoute->ascent_type_dict,
        ]);
    }
}
