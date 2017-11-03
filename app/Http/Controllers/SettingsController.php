<?php

namespace App\Http\Controllers;

use App\Lib\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return (new Settings())->getAll();
    }
}
