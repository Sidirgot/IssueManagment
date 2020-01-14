<?php

namespace App\Traits;

trait HandleProjectRelationships
{
    /**
     * Load Project related relationships.
     *
     * @param \App\Project $project
     * @return \App\Project
     */
    public function loadRelationships($project)
    {
        $project->load(['projectTesters', 'projectDevelopers', 'manager']);

        $project->issues->load(['owner', 'followups', 'closedBy'])->loadCount('followups');

        $project->loadCount([
            'issues as opened_issues' => function($query) {
                $query->opened();
            },
            'issues as closed_issues' => function($query) {
                $query->closed();
            }
        ]);

        return $project;
    }
}