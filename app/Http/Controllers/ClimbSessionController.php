<?php

namespace App\Http\Controllers;

use App\ClimbSession;
use App\Http\Resources\ClimbSessionCollection;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClimbSession  $climbSession
     * @return \Illuminate\Http\Response
     */
    public function show(ClimbSession $climbSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClimbSession  $climbSession
     * @return \Illuminate\Http\Response
     */
    public function edit(ClimbSession $climbSession)
    {
        //
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
