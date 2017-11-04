<?php

namespace Tests\Feature;

use App\ClimbSession;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClimbTest extends TestCase
{
    use RefreshDatabase;

    public function testClimbsIndex()
    {
        $climbsToTest = factory(ClimbSession::class, 5)->create();

        $response = $this->get('/api/climbs');
        $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'data'
            ]);

        $climbsData = $response->original['data'];
        $this->assertInternalType('array', $climbsData);

        foreach ($climbsData as $climbsDatum) {
            $this->assertTrue($climbsToTest->contains($climbsDatum['id']));
            $climb = $climbsToTest->find($climbsDatum['id']);
            $this->assertEquals($climb->name, $climbsDatum['name']);
            $this->assertEquals($climb->date->format('d.m.Y H:i'), $climbsDatum['date']);
        }

    }

    public function testClimbStore()
    {
        $climbDummy = factory(ClimbSession::class)->make();
        $response = $this->post('/api/climbs', [
            'name' => $climbDummy->name,
            'date' => $climbDummy->date->format('Y-m-d H:i')
        ]);
        $response
            ->assertJsonStructure(['id'])
            ->assertSuccessful();

        $climb = ClimbSession::find($response->original['id']);
        $this->assertNotNull($climb);
        $this->assertEquals($climbDummy->name, $climb->name);
        $this->assertEquals(
            $climbDummy->date->format('Y-m-d H:i'),
            $climb->date->format('Y-m-d H:i')
        );
    }

    public function testClimbGet()
    {
        $climbedRoute = factory(\App\ClimbedRoute::class)->make();
        $climb = factory(ClimbSession::class)->create();
        $climb->climbedRoutes()->save($climbedRoute);

        $response = $this->get('/api/climbs/' . $climb->id);
        $response
            ->assertJsonStructure([
                'data' => [
                    'date',
                    'name',
                    'climbedRoutes' => [
                        '*' => ['id', 'name', 'category_dict', 'proposed_category_dict']
                    ]
                ]
            ])
            ->assertSuccessful();

        $climbData = $response->original['data'];
        $this->assertEquals($climb->name, $climbData['name']);
        $this->assertEquals(
            $climb->date->format('d.m.Y H:i'),
            $climbData['date']
        );
        $this->assertCount(1, $climbData['climbedRoutes']);
        $climbedRouteData = $climbData['climbedRoutes'][0];
        $this->assertEquals($climbedRoute['name'], $climbedRouteData['name']);
        $this->assertEquals($climbedRoute['category_dict'], $climbedRouteData['category_dict']);
        $this->assertEquals($climbedRoute['proposed_category_dict'], $climbedRouteData['proposed_category_dict']);
    }

    public function testClimbGet404()
    {
        $this->get('/api/climbs/0')->assertStatus(404);
        $this->get('/api/climbs/asd')->assertStatus(404);
    }

}
