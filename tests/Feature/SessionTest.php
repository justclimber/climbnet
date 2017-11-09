<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionTest extends TestCase
{
    public function testExample()
    {
        $this->post('/api/session', [
            'expire' => 1510216370,
            'mid' => "46175246",
            'secret' => "oauth",
            'sid' => "79e9ef27d9baed7127261fecc20d911fc352fe9165e65b659dada076ade609a34794a24e661b256c59b08",
            'sig' => "779ffea1baae4fa9270f87165219e2ee"
        ])
            ->assertSuccessful()
            ->assertJson(['user_id' => 3]);
    }
}
