<?php

namespace Tests\Feature\API;

use App\Followup;
use App\Issue;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FollowUpsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function the_manager_that_is_part_of_the_project_can_submit_an_issue_followup()
    {
        $manager = $this->signInAs('manager');

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = factory(User::class)->create(['role' => 'tester']);

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $followup = factory(Followup::class)->raw();

        $response = $this->json('post', route('followups.store', [$issue->id, $project->id]), $followup)->assertStatus(201)->decodeResponseJson();

        $this->assertDatabaseHas('followups', ['body' => $followup['body']]);
        $this->assertEquals($followup['body'], $response['body']);
    }

     /** @test */
    public function the_tester_that_is_part_of_the_project_can_submit_an_issue_followup()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $followup = factory(Followup::class)->raw();

        $response = $this->json('post', route('followups.store', [$issue->id, $project->id]), $followup)->assertStatus(201)->decodeResponseJson();

        $this->assertDatabaseHas('followups', ['body' => $followup['body']]);
        $this->assertEquals($followup['body'], $response['body']);
    }

     /** @test */
    public function the_developer_that_is_part_of_the_project_can_submit_an_issue_followup()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $developer = $this->signInAs('developer');

        $project->assignDevelopers([$developer->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $developer->issues()->save($issueInformation);

        $followup = factory(Followup::class)->raw();

        $response = $this->json('post', route('followups.store', [$issue->id, $project->id]), $followup)->assertStatus(201)->decodeResponseJson();

        $this->assertDatabaseHas('followups', ['body' => $followup['body']]);
        $this->assertEquals($followup['body'], $response['body']);
    }

    /** @test */
    public function tester_that_is_part_of_the_project_can_see_all_the_issue_followups()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $followupData = $issue->followups()->make(factory(Followup::class)->raw());

        $followup = $tester->followups()->save($followupData);

        $response = $this->json('get', route('followups.index', [$project->id, $issue->id]))->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($response['followups'][0]['body'], $followup->body);
        $this->assertArrayHasKey('owner', $response['followups'][0]);
        $this->assertArrayHasKey('followups_count', $response);
    }

    /** @test */
    public function only_the_owner_of_the_followup_can_update_it()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $followupData = $issue->followups()->make(factory(Followup::class)->raw());

        $followup = $tester->followups()->save($followupData);

        $newData = ['body' => 'New follow up body. It was updated by the owner of the followup.'];

        $response = $this->json('patch', route('followups.update', $followup->id), $newData)->assertStatus(200)->decodeResponseJson();

        $this->assertEquals($newData['body'], $response['body']);

        $this->assertDatabaseMissing('followups', ['body' => $followup->body]);
        $this->assertDatabaseHas('followups', ['body' => $newData['body']]);
    }

    /** @test */
    public function only_the_owner_of_the_followup_can_delete_it()
    {
        $manager = factory(User::class)->create(['role' => 'manager']);

        $project = $manager->projects()->create(factory(Project::class)->raw());

        $tester = $this->signInAs('tester');

        $project->assignTesters([$tester->id]);

        $issueInformation = $project->issues()->make(factory(Issue::class)->raw());

        $issue = $tester->issues()->save($issueInformation);

        $followupData = $issue->followups()->make(factory(Followup::class)->raw());

        $followup = $tester->followups()->save($followupData);

        $this->json('delete', route('followups.destroy', $followup->id))->assertStatus(200);

        $this->assertDatabaseMissing('followups', ['body' => $followup->body]);
    }
}