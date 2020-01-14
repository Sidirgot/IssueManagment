<?php

namespace App\Http\Controllers\API\Team;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.layouts.dashboard');
    }
}