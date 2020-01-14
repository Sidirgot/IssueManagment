<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Issue;
use App\Project;
use Carbon\Carbon;

class IssuesStatusController extends Controller
{
    /**
     * Close the given issue.
     *
     * @param \App\Project $project
     * @param \App\Issue $issue
     */
    public function status(Project $project, Issue $issue)
    {
        $this->authorize('isPartOfTheProject', $project);

        $issue->close();

        return response()->json($issue, 200);
    }

    /**
     * Get all the opened issues for a given project
     *
     * @param \App\Project $project
     */
    public function opened(Project $project)
    {
        $issues =  $project->issues->each(function($issue) {
            $issue->opened();
        });

        return response()->json($issues, 200);
    }

    /**
     * Get all the closed issues for a given project
     *
     * @param \App\Project $project
     */
    public function closed(Project $project)
    {
        $issues =  $project->issues->each(function($issue) {
            $issue->closed();
        });

        return response()->json($issues, 200);
    }
}
