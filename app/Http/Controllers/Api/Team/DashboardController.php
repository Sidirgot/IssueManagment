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

    /**
     * Get team's dashboard information
     *
     */
    public function dashboard()
    {
        if (auth()->user()->isTester()) {
            return $this->tester_information();
        }

        if (auth()->user()->isDeveloper()) {
            return $this->developer_information();
        }

    }

    /**
     * Get tester dashborad information
     *
     */
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

    /**
     * Get developer dashborad information
     *
     */
    protected function developer_information()
    {
        $projects = auth()->user()->developerProjects()->latest()->get();

        $total_projects = $projects->count();
        $latest_projects = $projects->take(5);

        return response()->json([
            'total_projects' => $total_projects,
            'latest_projects' => $latest_projects,
        ]);
    }
}