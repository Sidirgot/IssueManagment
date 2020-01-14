<?php

namespace App\Http\Controllers\API\Team;

use App\Events\IssueCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\IssueRequest;
use App\Issue;
use App\Project;

class ProjectIssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = auth()->user()->issues()->paginate(10);

        return response()->json($issues, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IssueRequest $request, Project $project)
    {
        $this->authorize('assigned', $project);

        $issueInformation = $project->issues()->make($request->validated());

        $issue = auth()->user()->issues()->save($issueInformation);

        $issue->load(['owner','followups'])->withCount('followups');

        broadcast(new IssueCreated($issue, $project))->toOthers();

        return response()->json($issue, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        $this->authorize('owner', $issue);

        return response()->json($issue, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(IssueRequest $request, Issue $issue)
    {
        $this->authorize('owner', $issue);

        $issue->update($request->validated());

        return response()->json($issue, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $this->authorize('owner', $issue);

        $issue->delete();

        return response()->json('Issue deleted succesfully', 200);
    }
}
