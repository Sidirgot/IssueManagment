<?php

namespace Tests\Feature\Api;

use App\Issue;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IssueStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function everyone_that_is_a_part_of_a_given_project_can_close_an_issue()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $response = $this->json('patch', route('issue.status', [$project->id, $issue->id]))->assertStatus(200)
                                                                                           ->decodeResponseJson();

        $this->assertDatabaseMissing('issues', ['status' => $issue->status]);

        $this->assertDatabaseHas('issues', ['status' => $issue->fresh()->status]);

        $this->assertEquals('closed', $issue->fresh()->status);
        $this->assertNotNull($issue->fresh()->closed_on);
        $this->assertNotNull($issue->fresh()->closed_by);
    }

    /** @test */
    public function fetch_opened_issues_for_a_given_project()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $response = $this->json('get', route('issues.opened', $project->id))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($issue->title, $response[0]['title']);
        $this->assertEquals($issue->status, $response[0]['status']);
    }

    /** @test */
    public function fetch_closed_issues_for_a_given_project()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $issue->close();

        $response = $this->json('get', route('issues.closed', $project->id))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($issue->title, $response[0]['title']);
        $this->assertEquals($issue->status, $response[0]['status']);
        $this->assertEquals('closed', $response[0]['status']);
    }
}