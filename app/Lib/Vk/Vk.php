<?php

namespace App\Lib\Vk;

use App\User;
use Illuminate\Support\Arr;

class Vk
{
    private $appId;
    private $secret;

    public function __construct(array $config)
    {
        $this->appId = Arr::get($config, 'app_id');
        $this->secret = Arr::get($config, 'secret');
    }

    public function validateSig(array $sigParts, string $sig)
    {
        // @todo: check expire
        ksort($sigParts);
        $sigToCheck = '';
        foreach ($sigParts as $key => $value) {
            $sigToCheck .= "$key=$value";
        }
        $sigToCheck .= $this->secret;

        return md5($sigToCheck) === $sig;
    }

    public function getUserFromVkData(array $sessionData): User
    {
        $user = User::firstOrCreate(
            ['vk_id' => $sessionData['id']],
            ['name' => $sessionData['first_name'] . ' ' . $sessionData['last_name']]
        );

        return $user;
    }
}
