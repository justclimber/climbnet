<?php

namespace App\Http\Controllers;

use App\ClimbSession;
use App\Http\Resources\ClimbSessionCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClimbSession  $climbSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClimbSession $climbSession)
    {
        //
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
