<?php

namespace App\Http\Controllers;

use App\ClimbedRoute;
use App\ClimbSession;
use Illuminate\Http\Request;

class ClimbedRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => '',
            'category_dict' => '',
            'proposed_category_dict' => '',
            'route_type_dict' => '',
            'ascent_type_dict' => '',
            'comment' => '',
            'climb_session_id' => 'required|integer',
        ]);

        if (!($climb = ClimbSession::find($data['climb_session_id']))
            || $climb->user_id != \Auth::id()
        ) {
            return $this->jsonAccessDenied();
        }

        $climb = ClimbSession::find($data['climb_session_id']);

        $climbedRoute = $climb->climbedRoutes()->save(ClimbedRoute::make($data));

        return ['id' => $climbedRoute->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClimbedRoute $climbedRoute
     * @return \App\Http\Resources\ClimbedRoute
     */
    public function show(ClimbedRoute $climbedRoute)
    {
        return new \App\Http\Resources\ClimbedRoute($climbedRoute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClimbedRoute  $climbedRoute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClimbedRoute $climbedRoute)
    {
        if ($climbedRoute->climbSession->user_id != \Auth::id()) {
            return $this->jsonAccessDenied();
        }

        $data = $request->validate([
            'name' => '',
            'category_dict' => '',
            'proposed_category_dict' => '',
            'route_type_dict' => '',
            'ascent_type_dict' => '',
            'comment' => '',
        ]);

        $climbedRoute->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClimbedRoute  $climbedRoute
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClimbedRoute $climbedRoute)
    {
        //
    }
}
