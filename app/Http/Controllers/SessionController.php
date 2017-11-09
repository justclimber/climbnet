<?php

namespace App\Http\Controllers;

use App\Lib\Vk\Vk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|JsonResponse
     */
    public function store(Request $request)
    {
        $sigParts = $request->only(['expire', 'mid', 'secret', 'sid']);
        $sig = $request->get('sig');
        $vk = new Vk(config('services.vk'));

        if (!$vk->validateSig($sigParts, $sig)) {
            return \Response::json(['errorMessage' => 'Bad vk signature'], Response::HTTP_BAD_REQUEST);
        }

        return ['user_id' => 3];
    }
}
