<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClimbTest extends TestCase
{
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

    public function testClimbsCreate()
    {
        $response = $this->get('/climbs/create');
        $response
            ->assertSuccessful();
    }
}
