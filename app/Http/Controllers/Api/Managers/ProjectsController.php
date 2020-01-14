<?php

namespace App\Http\Controllers\Api\Managers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Project;
use App\Traits\HandleProjectRelationships;

class ProjectsController extends Controller
{
    use HandleProjectRelationships;

    /**
     * Return all the projects of the authenticated user
     *
     * @return void
     */
    public function index()
    {
        $projects = auth()->user()->projects()->paginate(15);

        $projects->loadCount(['issues as opened_issues' => function($query) {
            $query->opened();
        }]);

        return response()->json($projects, 200);
    }

    /**
     * Store a new project
     *
     * @param \App\Http\Requests\ProjectRequest $request
     *
     * @return void
     */
    public function store(ProjectRequest $request)
    {
        $project = auth()->user()->projects()->create($request->validated());

        $this->loadRelationships($project);

        return response()->json($project, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('owner', $project);

        $project->update($request->validated());

        $this->loadRelationships($project);

        return response()->json($project, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('owner', $project);

        $project->delete();

        return response()->json('Project Deleted Successfully', 200);
    }
}
