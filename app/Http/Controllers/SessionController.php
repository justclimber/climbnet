<?php

namespace App\Http\Controllers;

use App\Http\Resources\User;
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
        $request->validate([
            'expire' => 'required',
            'mid' => 'required',
            'secret' => 'required',
            'sid' => 'required',
            'sig' => 'required',
            'user.id' => 'required',
            'user.first_name' => 'required',
            'user.last_name' => 'required',
        ]);
        $sigParts = $request->only(['expire', 'mid', 'secret', 'sid']);
        $sig = $request->get('sig');
        $vk = new Vk(config('services.vk'));

        if (!$vk->validateSig($sigParts, $sig)) {
            return \Response::json(['errorMessage' => 'Bad vk signature'], Response::HTTP_BAD_REQUEST);
        }

        $user = $vk->getUserFromVkData($request->get('user'));

        \Auth::login($user, true);

        return [
            'user' => new User($user),
            'isJustRegistered' => $user->wasRecentlyCreated
        ];
    }
}
