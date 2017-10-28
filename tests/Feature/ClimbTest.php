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
        $response = $this->get('/climbs');
        $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'data'
            ]);

        $climbsData = $response->original['data'];

        $this->assertInternalType('array', $climbsData);

        if (count($climbsData)) {
            $response->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'date', 'name']
                ]
            ]);
        }


    }

    public function testClimbStore()
    {
        $climbDataToTest = [
            'name' => 'test name',
            'date' => '2017-12-12 12:12:12'
        ];
        $response = $this->post('/climbs', $climbDataToTest);
        $response
            ->assertJsonStructure(['id'])
            ->assertSuccessful();

        $climb = ClimbSession::find($response->original['id']);
        $this->assertNotNull($climb);
        $this->assertEquals($climbDataToTest['name'], $climb->name);
    }
}
