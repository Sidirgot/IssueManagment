<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\Controller;
use App\Issue;
use App\Traits\HandleProjectRelationships;

class DashboardController extends Controller
{
    use HandleProjectRelationships;

    public function index()
    {
        return view('backend.layouts.dashboard');
    }

    public function dashboard()
    {
        if (auth()->user()->isTester()) {

            return $this->tester_information();
            
        }

        if (auth()->user()->isDeveloper()) {
            $projects = auth()->user()->developerProjects()->get();
        }

    }

    protected function tester_information()
    {
        $projects = auth()->user()->testerProjects()->latest()->get();

        $total_projects = $projects->count();
        $latest_projects = $projects->take(5);
        $total_opened_issues = auth()->user()->issues()->opened()->count();

        return response()->json([
            'total_projects' => $total_projects,
            'latest_projects' => $latest_projects,
            'total_opened_issues' => $total_opened_issues
        ]);
    }
}