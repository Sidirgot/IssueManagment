<?php

namespace App\Policies;

use App\Issue;
use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user is the owner of the issue.
     *
     * @param \App\User $user
     * @param \App\Project $project
     * @return mixed
     */
    public function owner(User $user, Issue $issue)
    {
        return $user->canAccessIssue($issue);
    }
}
