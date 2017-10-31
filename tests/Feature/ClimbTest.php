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

        $response = $this->get('/climbs');
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
        $response = $this->post('/climbs', [
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
}
