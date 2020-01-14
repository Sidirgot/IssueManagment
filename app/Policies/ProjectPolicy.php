<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user is part of the given project.
     *
     * @param \App\User $user
     * @param \App\Project $project
     */
    public function isPartOfTheProject(User $user, Project $project)
    {
        if ($user->isManager()) {
            return $this->owner($user, $project);
        } else if ($user->isTester() || $user->isDeveloper()) {
            return $this->assigned($user, $project);
        }
    }

    /**
     * Determine if the user is the owner of the project.
     *
     * @param \App\User $user
     * @param \App\Project $project
     * @return mixed
     */
    public function owner(User $user, Project $project)
    {
        return $user->canAccessProject($project);
    }

    /**
     * Determine if the user has been assigned on this project and if the project is open.
     *
     * @param \App\User $user
     * @param \App\Project $project
     * @return mixed
     */
    public function assigned(User $user, Project $project)
    {
        return $user->accessibleProjects($project) && $project->isOpened();
    }
}
