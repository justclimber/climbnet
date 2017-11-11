<?php

namespace App\Http\Controllers;

use App\Lib\Settings;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $settings = (new Settings())->getAll();
        $user = \Auth::user();
        return view('landing', compact('settings', 'user'));
    }
}
