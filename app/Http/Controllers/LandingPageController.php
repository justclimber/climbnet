<?php

namespace App\Http\Controllers;

use App\Http\Resources\User;
use App\Lib\Settings;

class LandingPageController extends Controller
{
    public function index()
    {
        $settings = (new Settings())->getAll();
        $user = new User(\Auth::user());
        return view('landing', compact('settings', 'user'));
    }
}
