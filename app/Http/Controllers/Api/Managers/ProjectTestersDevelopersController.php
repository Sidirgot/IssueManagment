<?php

namespace App\Http\Controllers\Api\Managers;

use App\Project;
use App\User;
use App\Traits\HandleProjectRelationships;
use App\Http\Controllers\Controller;


class ProjectTestersDevelopersController extends Controller
{
    use HandleProjectRelationships;

    /**
     * Get the unassigned testers for the given project.
     *
     * @return \Illuminate\Http\Response
     */
    public function unassignedTesters(Project $project)
    {
        $testers = $this->getUnassignedTesters($project);

        return response()->json($testers, 200);
    }

    /**
     * Get the unassigned developers for the given project.
     *
     * @return \Illuminate\Http\Response
     */
    public function unassignedDevelopers(Project $project)
    {
        $developers = $this->getUnassignedDevelopers($project);

        return response()->json($developers, 200);
    }

    /**
     * Assign a tester to a given project.
     *
     * @param Project $project
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function assignTester(Project $project, User $user)
    {
        $project->assignTesters([$user->id]);

        $this->loadRelationships($project);

        $testers = $this->getUnassignedTesters($project);

        return response()->json(['project' => $project, 'testers' => $testers], 200);
    }

    /**
     * Assign a developer to a given project.
     *
     * @param Project $project
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function assignDeveloper(Project $project, User $user)
    {
        $project->assignDevelopers([$user->id]);

        $this->loadRelationships($project);

        $developers = $this->getUnassignedDevelopers($project);

        return response()->json(['project' => $project, 'developers' => $developers], 200);
    }

    /**
     * Remove a tester from a project.
     *
     * @param Project $project
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function removeTester(Project $project, int $id)
    {
        $project->detachTesters([$id]);

        $this->loadRelationships($project);

        $testers = $this->getUnassignedTesters($project);

        return response()->json(['project' => $project, 'testers' => $testers], 200);
    }

    /**
     * Remove a developer from a project.
     *
     * @param Project $project
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function removeDeveloper(Project $project, int $id)
    {
        $project->detachDevelopers([$id]);

        $this->loadRelationships($project);

        $developers = $this->getUnassignedDevelopers($project);

        return response()->json(['project' => $project, 'developers' => $developers], 200);
    }

    /**
     * Gather the unassigned testers for the given project.
     *
     * @param Project $project
     */
    protected function getUnassignedTesters(Project $project)
    {
        $projectTesters = $project->projectTesters()->pluck('id')->toArray();

        $testers = User::testers()->notPartOfTheProject($projectTesters)->get();

        return $testers;
    }

    /**
     * Gather the unassigned developers for the given project.
     *
     * @param Project $project
     */
    protected function getUnassignedDevelopers(Project $project)
    {
        $projectDevelopers = $project->projectDevelopers()->pluck('id')->toArray();

        $developers= User::developers()->notPartOfTheProject($projectDevelopers)->get();

        return $developers;
    }
}
