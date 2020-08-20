<?php

namespace Tests\Feature\API\Team;

use App\Issue;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectIssueControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function testers_can_create_an_issue_refering_to_a_given_project()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issue = factory(Issue::class)->raw();

        $this->json('post', route('issues.store', $project->id),$issue)->assertStatus(201);

        $this->assertDatabaseHas('issues', ['title' => $issue['title']]);
        $this->assertDatabaseHas('issues', ['description' => $issue['description']]);
        $this->assertDatabaseHas('issues', ['priority' => $issue['priority']]);
        $this->assertDatabaseHas('issues', ['status' => $issue['status']]);
    }

    /** @test */
    public function testers_can_get_all_the_issues_they_have_created()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $response = $this->json('get', route('issues.index'))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($issue->title, $response['data'][0]['title']);
    }

    /** @test */
    public function testers_can_get_an_issue_they_have_created()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $response = $this->json('get', route('issues.show', $issue->id))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($issue->title, $response['title']);
    }

    /** @test */
    public function testers_can_update_an_issue_that_they_have_created()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $newIssueData = ['title' => 'this is the new title', 'description' => 'new description that must be at least 30 characters long.'];

        $this->json('patch', route('issues.update', $issue->id), $newIssueData)->assertStatus(200);

        $this->assertDatabaseMissing('issues', ['title' => $issue->title]);
        $this->assertDatabaseMissing('issues', ['description' => $issue->description]);
        $this->assertDatabaseHas('issues', ['title' => $newIssueData['title']]);
        $this->assertDatabaseHas('issues', ['description' => $newIssueData['description']]);
    }

    /** @test */
    public function testers_can_delete_an_issue_they_have_created()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $this->json('delete', route('issues.destroy', $issue->id))->assertStatus(200);

        $this->assertDatabaseMissing('issues', ['title' => $issue->title]);
        $this->assertDatabaseMissing('issues', ['description' => $issue->description]);
    }
}
