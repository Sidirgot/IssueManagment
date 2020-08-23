<?php

namespace App\Http\Controllers\Api\Managers;

use App\Http\Controllers\Controller;
use App\Issue;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.layouts.dashboard');
    }

    public function dashboard()
    {
        $projects = auth()->user()->projects()->opened()->latest()->get();

        $total_projects = $projects->count();
        $total_issues = Issue::opened()->latest()->get();
        $latest_projects = $projects->take(10);

        return response()->json([
            'total_projects' => $total_projects,
            'total_issues' => $total_issues->count(),
            'projects' => $latest_projects,
            'latest_issues' => $total_issues->take(10)
        ]);
    }
}
