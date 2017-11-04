<?php

namespace Tests\Feature;

use App\ClimbedRoute;
use App\ClimbSession;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClimbedRouteTest extends TestCase
{
    use RefreshDatabase;

    public function testClimbedRouteStore()
    {
        $climb = factory(ClimbSession::class)->create();
        $climbedRouteDummy = factory(ClimbedRoute::class)->make();

        $response = $this->post('/api/climbed-routes', [
            'name' => $climbedRouteDummy->name,
            'climb_session_id' => $climb->id,
            'category_dict' => $climbedRouteDummy->category_dict,
            'proposed_category_dict' => $climbedRouteDummy->proposed_category_dict,
        ]);
        $response
            ->assertJsonStructure(['id'])
            ->assertSuccessful();

        $climbedRoute = ClimbedRoute::find($response->original['id']);
        $this->assertNotNull($climbedRoute);
        $this->assertEquals($climbedRouteDummy->name, $climbedRoute->name);
        $this->assertEquals($climbedRouteDummy->category_dict, $climbedRoute->category_dict);
        $this->assertEquals($climbedRouteDummy->proposed_category_dict, $climbedRoute->proposed_category_dict);
    }
}
