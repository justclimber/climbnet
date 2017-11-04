<?php

namespace Tests\Feature;

use Tests\TestCase;

class SettingsTest extends TestCase
{
    public function testDicts()
    {
        $response = $this->get('/api/settings');
        $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'dicts' => ['categories']
            ]);

        $response->assertSee('9a');
        $response->assertSee('5a+');
        $response->assertDontSee('4a');
        $response->assertDontSee('9c+');
    }
}
