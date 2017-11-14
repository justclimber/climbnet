<?php

namespace App\Http\Controllers;

use App\ClimbSession;
use App\Http\Resources\ClimbSessionCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClimbSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ClimbSessionCollection(ClimbSession::all());
    }

    /**
     * Display a listing of the resource.
     */
    public function myclimbs()
    {
        return new ClimbSessionCollection(ClimbSession::byUser(\Auth::id())->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => '',
            'date' => 'required',
        ]);
        $data['date'] = Carbon::createFromFormat('Y-m-d H:i', $data['date']);
        $data['user_id'] = \Auth::id();

        $climb = ClimbSession::create($data);

        return ['id' => $climb->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClimbSession $climbSession
     * @return \App\Http\Resources\ClimbSession
     */
    public function show(ClimbSession $climbSession)
    {
        return new \App\Http\Resources\ClimbSession($climbSession);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ClimbSession $climbSession
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ClimbSession $climbSession)
    {
        if ($climbSession->user_id != \Auth::id()) {
            return $this->jsonAccessDenied();
        }
        $data = $request->validate([
            'name' => '',
            'date' => 'required',
        ]);
        $data['date'] = Carbon::createFromFormat('Y-m-d H:i', $data['date']);

        $climbSession->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClimbSession  $climbSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClimbSession $climbSession)
    {
        //
    }
}
