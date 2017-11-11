<?php

namespace Tests\Feature;

use App\ClimbSession;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClimbTest extends TestCase
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

    public function testClimbsIndex()
    {
        $climbsToTest = factory(ClimbSession::class, 5)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/climbs');
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
            $this->assertEquals($climb->user_id, $this->user->id);
        }
    }

    public function testClimbStore()
    {
        $climbDummy = factory(ClimbSession::class)->make();
        $response = $this->postJson('/api/climbs', [
            'name' => $climbDummy->name,
            'date' => $climbDummy->date->format('Y-m-d H:i')
        ]);
        $response
            ->assertJsonStructure(['id'])
            ->assertSuccessful();

        $climb = ClimbSession::find($response->original['id']);
        $this->assertNotNull($climb);
        $this->assertEquals($this->user->id, $climb->user_id);
        $this->assertEquals($climbDummy->name, $climb->name);
        $this->assertEquals(
            $climbDummy->date->format('Y-m-d H:i'),
            $climb->date->format('Y-m-d H:i')
        );
    }

    public function testClimbStoreWithMessUserIdIsSafe()
    {
        $climbDummy = factory(ClimbSession::class)->make(['user_id' => 123]);
        $response = $this->postJson('/api/climbs', [
            'name' => $climbDummy->name,
            'date' => $climbDummy->date->format('Y-m-d H:i'),
            'user_id' => $climbDummy->user_id
        ]);
        $response
            ->assertJsonStructure(['id'])
            ->assertSuccessful();

        $climb = ClimbSession::find($response->original['id']);
        $this->assertNotNull($climb);
        $this->assertEquals($climb->user_id, $this->user->id);
    }

    public function testClimbGet()
    {
        $climbedRoute = factory(\App\ClimbedRoute::class)->make();
        $climb = factory(ClimbSession::class)->create(['user_id' => $this->user->id]);
        $climb->climbedRoutes()->save($climbedRoute);

        $response = $this->getJson('/api/climbs/' . $climb->id);
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
        $this->getJson('/api/climbs/0')->assertStatus(404);
        $this->getJson('/api/climbs/asd')->assertStatus(404);
    }

    public function testOnlyMyClimbs()
    {
        $anotherUser = factory(User::class)->create();
        factory(ClimbSession::class, 5)->create(['user_id' => $anotherUser->id]);
        factory(ClimbSession::class, 5)->create(['user_id' => $this->user->id]);
        $response = $this->getJson('/api/climbs/my');
        $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'data'
            ]);
        
        $climbsData = $response->original['data'];
        $this->assertInternalType('array', $climbsData);

        foreach ($climbsData as $climbsDatum) {
            $this->assertEquals($climbsDatum['user_id'], $this->user->id);
        }
    }
}
