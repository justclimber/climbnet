<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClimbTest extends TestCase
{
    public function testClimbs()
    {
        $response = $this->get('/climbs');
        $response
            ->assertSuccessful();
    }

    public function testClimbsCreate()
    {
        $response = $this->get('/climbs/create');
        $response
            ->assertSuccessful();
    }
}
