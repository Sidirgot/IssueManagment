<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Project;
use App\Traits\HandleProjectRelationships;

class ProjectsController extends Controller
{
    use HandleProjectRelationships;

    /**
     * Get all the authenticated users projects.
     *
     */
    public function assignedProjects()
    {
        if (auth()->user()->isTester()) {
            return $this->fetchTestersProjects();
        }

        if (auth()->user()->isDeveloper()) {
            return $this->fetchDevelopersProjects();
        }
    }

    /**
     * Find the requested project.
     *
     * @param Project $project
     */
    public function show(Project $project)
    {
        $this->authorize('isPartOfTheProject', $project);

        $this->loadRelationships($project);

        return response()->json($project, 200);
    }

    /**
     * Gather all the testers projects.
     *
     */
    protected function fetchTestersProjects()
    {
        $projects = auth()->user()->testerProjects()->latest()->paginate(20);

        $projects->loadCount([
            'issues as opened_issues' => function($query) {
                $query->opened();
            },
        ]);

        return response()->json($projects, 200);
    }

    /**
     * Gather all the developers projects.
     *
     */
    protected function fetchDevelopersProjects()
    {
        $projects = auth()->user()->developerProjects()->latest()->paginate(20);

        $this->loadRelationships($projects);

        return response()->json($projects, 200);
    }
}
