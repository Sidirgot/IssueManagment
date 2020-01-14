<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Issue;
use App\Project;

class ProjectIssueController extends Controller
{
    /**
     * Get the specified issue and
     * load its owner and all the related followups.
     *
     * @param \App\Project $project
     * @param \App\Issue $issue
     * @return void
     */
    public function getIssue(Project $project, Issue $issue)
    {
        $this->authorize('isPartOfTheProject', $project);

        $issue->load(['owner', 'closedBy']);

        $issue->followups->load('owner');

        return response()->json($issue, 200);
    }
}
