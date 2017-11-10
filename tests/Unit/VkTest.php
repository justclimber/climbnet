<?php

namespace Tests\Unit;

use App\Lib\Vk\Vk;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VkTest extends TestCase
{
    use RefreshDatabase;

    public function provideVkSessionData()
    {
        return [[[
            'expire' => 1510216370,
            'mid' => "46175246",
            'secret' => "oauth",
            'sid' => "79e9ef27d9baed7127261fecc20d911fc352fe9165e65b659dada076ade609a34794a24e661b256c59b08",
            'sig' => "779ffea1baae4fa9270f87165219e2ee",
            'user' => [
                'id' => 123456789,
                'first_name' => "Jhon",
                'last_name' => "Doe",
            ]
        ]]];
    }

    /**
     * @dataProvider provideVkSessionData
     * @param array $sessionData
     */
    public function testSessionValid(array $sessionData)
    {
        $vk = new Vk(config('services.vk'));

        $this->assertTrue($vk->validateSig(
            array_only($sessionData, ['expire', 'mid', 'secret', 'sid']),
            array_get($sessionData, 'sig')
        ));
    }

    /**
     * @dataProvider provideVkSessionData
     * @param array $sessionData
     */
    public function testGetUser(array $sessionData)
    {
        $vk = new Vk(config('services.vk'));

        $user = $vk->getUserFromVkData($sessionData['user']);

        $firstName = array_get($sessionData, 'user.first_name');
        $lastName = array_get($sessionData, 'user.last_name');

        $this->assertEquals($user->name, "$firstName $lastName");
        $this->assertInternalType('integer', $user->id);
        $this->assertEquals($sessionData['user']['id'], $user->vk_id);
    }
}
