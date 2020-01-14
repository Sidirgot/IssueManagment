<?php

namespace Tests\Feature\Api;

use App\Followup;
use App\Issue;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectIssueControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function anyone_that_is_part_of_the_project_can_fetch_a_given_issue_with_all_the_issue_followups()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $followupData = $issue->followups()->make(factory(Followup::class)->raw());

        $followup = $tester->followups()->save($followupData);

        $response = $this->json('get', route('project.issue.followups', [$project->id, $issue->id]))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($issue->title, $response['title']);
    }
}