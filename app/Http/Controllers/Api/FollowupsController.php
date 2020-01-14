<?php

namespace App\Http\Controllers\Api;

use App\Followup;
use App\Http\Controllers\Controller;
use App\Http\Requests\FollowupRequest;
use App\Issue;
use App\Project;

class FollowupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Project $project, Issue $issue)
    {
        $this->authorize('isPartOfTheProject', $project);

        $followups = $issue->followups()->get()->load('owner');

        $followups_count = $issue->followups()->count();

        return response()->json(['followups' => $followups, 'followups_count' => $followups_count], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FollowupRequest  $request
     * @param  \App\Issue  $issue
     * @param  \App\Project  $project
     */
    public function store(FollowupRequest $request, Issue $issue, Project $project)
    {
        $this->authorize('isPartOfTheProject', $project);

        $followupData = $issue->followups()->make($request->validated());

        $followup = auth()->user()->followups()->save($followupData)->load('owner');

        return response()->json($followup, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FollowupRequest  $request
     * @param  \App\Followup  $followup
     */
    public function update(FollowupRequest $request, Followup $followup)
    {
        $this->authorize('owner', $followup);

        $followup->update($request->validated());

        $followup->load('owner');

        return response()->json($followup, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Followup  $followup
     */
    public function destroy(Followup $followup)
    {
        $this->authorize('owner', $followup);

        $followup->delete();

        return response()->json('Deleted Successfully', 200);
    }
}
