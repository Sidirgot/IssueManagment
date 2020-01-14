<?php

namespace App\Http\Controllers\Api\Managers;

use App\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Traits\HandleProjectRelationships;

class ProjectStatusController extends Controller
{
    use HandleProjectRelationships;

    /**
     * Update project status
     *
     * @param ProjectRequest $projectRequest
     * @param Project $project
     * @return void
     */
    public function handleProjectStatus(ProjectRequest $projectRequest, Project $project)
    {
        $this->authorize('owner', $project);

        $projectRequest->updateProjectStatus($project);

        $this->loadRelationships($project);

        return response()->json($project, 200);
    }
}
