<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * The welcome page for the application
     *
     * @return void
     */
    public function main()
    {
        return view('layouts.main');
    }
}
